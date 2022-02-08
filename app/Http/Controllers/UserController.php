<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Action;
use App\Asset;
use App\Event;
use App\Events\User\CreatedEvent;
use App\Events\User\PostedStatusUpdate;
use App\File;
use App\Notification;
use App\Notifications\NewPost;
use App\Phase\Feed\ProfileActivityFeedGenerator;
use App\Post;
use App\User;
use Auth;
use Carbon\Carbon;
use App\Phase\ImageManager;
use App\Release;

class UserController extends Controller
{
    public function follow(Request $request, $targetID)
    {
        $target = User::findOrFail($targetID);
        $request->user()->follow($target);
    }

    public function unfollow(Request $request, $targetID)
    {
        $target = User::findOrFail($targetID);
        $request->user()->unfollow($target);
    }

    public function uploadAvatar(Request $request)
    {
        $data = $request->validate([
            'avatar' => 'required|dimensions:min_width=350,min_height=350'
        ]);
        $user = $request->user();
        $user->newAvatar($data['avatar']);
        $user = $user->refresh();

        return $user->avatar;
    }

    public function uploadBanner(Request $request)
    {
        $data = $request->validate([
            'banner' => 'required|dimensions:min_width=800,min_height=500'
        ]);

        $user = $request->user();
        $user->newProfileBanner($request->file('banner'));
        $user = $user->refresh();

        return $user->banner;
    }

    /**
     * delete banner
     *
     * 
     */
    public function deleteBanner(Request $request)
    {
        $user = $request->user();
        $user->deleteBanner();

        return $user->banner;
    }

    public function getUser(Request $request, $path = null)
    {
        if ($path !== 'search') {
            $user =  User::byPath($path)
                ->with([
                    'following',
                ])
                ->withCount(['releases', 'followers as follower_count', 'following as following_count'])
                ->first();
            if ($request->has('app-user') && $request->get('app-user') != -1) {
                $followable = User::with('following')->find($request->get('app-user'));
                $user->followed = $user->followers->contains($followable);
            } else {
                $user->followed = false;
            }
            $likes = $user->likes;
            foreach ($likes as $like) {
                $like->likeable;
            }

            return $user;
        }

        return User::where('name', 'LIKE', '%' . $request->get('name') . '%')
            ->with([
                'avatar'
            ])
            ->withCount('releases')
            ->get();
    }

    // Unused. Use me!
    public function getPostsFromUser($userid)
    {
        return Post::where('user_id', $userid)->withCount('comments', 'likes', 'shares')->orderByDesc('created_at')->get();
    }

    public function getPostsForUser($userID)
    {
        $user = User::findOrFail($userID);

        $userActions = $user->actions;

        return $userActions->where('item_type', 'post')
            ->sortByDesc('created_at')
            ->values();
    }

    public function getEventsForUser($userID)
    {
        return User::findOrFail($userID)->events()
            ->orderBy('date', 'asc')
            ->get();
    }

    public function getVideosForUser($userID)
    {
        return User::findOrFail($userID)->videos()
            ->get();
    }

    public function getReleasesForUser($userId)
    {
        return Release::where('uploaded_by', $userId)
            ->where('status', 'live')
            ->with([
                'image',
                'tracks',
                'tracks.preview',
            ])
            ->withCount('shares', 'likes', 'comments')
            ->latest('release_date')
            ->paginate(15);
    }

    public function getActivityForUser($userID)
    {
        $user = User::findOrFail($userID);

        $feed = new ProfileActivityFeedGenerator($user);

        return $feed->getActionsForProfile();
    }

    public function getMerchForUser($userID)
    {
        return User::findOrFail($userID)->merch()
            ->orderByDesc('created_at')->get();
    }

    public function postStatusUpdate(Request $request)
    {
        $validated = $request->validate([
            'body' => 'nullable|sometimes|string',
            'attachment' => 'nullable|sometimes|mimes:jpeg,bmp,png',
            'target_id' => 'nullable|integer|exists:users,id'
        ]);
        $user_id = $request->user()->id;
        $body = $validated['body'];
        $targetID = (isset($validated['target_id']) ? $validated['target_id'] : null);
        if ($request->hasFile('attachment')) {
            $image = ImageManager::resource($request->file('attachment'))
                ->directory("posts/{$user_id}")
                ->altText('')
                ->storeMedium()
                ->storeThumb();
        }

        $post = new Post([
            'user_id' => $user_id,
            'target_id' => $targetID,
            'body' => $body,
            'asset_id' => isset($image) ? $image->asset->id : null
        ]);
        $post->save();

        //check if the post is not added on the active user's profile then notify the profile owner as well
        if ($user_id != $targetID) {
            $targetProfileUser = User::find($targetID);
            Notification::notifyUser($targetProfileUser, new NewPost($post, 'remote'));
        }

        //notify poster followers
        Notification::notifyFollowers($request->user(), new NewPost($post, 'self'));
        event(new PostedStatusUpdate($post));

        // Refetch to include eager loaded relationships
        $action = Action::where('item_type', 'post')
            ->where('item_id', $post->id)
            ->first();

        return [
            'success' => true,
            'action' => $action
        ];
    }

    public function postNewEvent(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'date' => 'required|date',
        ]);
        $manager = ImageManager::resource($data['image'])
            ->directory('images/events')
            ->altText('Event Image')
            ->square()
            ->storeOriginal()
            ->storeLarge()
            ->storeMedium()
            ->storeThumb();

        $event = Event::create([
            'user_id' => $request->user()->id,
            'image_id' => $manager->asset->id,
            'name' => $data['name'],
            'location' => $data['location'],
            'url' => $data['url'],
            'date' => Carbon::parse($data['date'])
        ]);
        $event->refresh();

        event(new CreatedEvent($event));

        return $event;
    }

    /**
     * Return activity of all the users that the currently authenticated user is following
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function getFeed(Request $request)
    {
        $user = $request->user();
        $result = collect();
        foreach ($user->following as $followed) {
            $feed = new ProfileActivityFeedGenerator($followed);
            $result = $result->merge($feed->getActionsForProfile()->all());
        }
        $result->sortByDesc('created_at');

        return $result;
    }

    /**
     * Return user notifications
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function getNotificationsForUser(Request $request, $id)
    {
        $user = User::find($id);

        return $user->unreadNotifications->take(10);
    }

    /**
     * Mark user notification read
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function MarkNotificationRead(Request $request, $id)
    {
        $request->user()->notifications->where('id', $id)->markAsRead();
    }

    /**
     * Soft delete the object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if (Auth::id() != $id) {
            return null;
        }

        //sign user out
        Auth::logout();

        //soft delete user
        User::destroy($id);
    }

    /**
     * Restore a soft deleted object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        User::onlyTrashed()->where('email', $request->get('email'))->restore();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::id() != $id) {
            return null;
        }

        //get user
        $user = User::where('id', $id)->first();

        //force delete user avatar
        $asset = Asset::where('id', $user->avatar_id)->first();
        if ($asset) {
            File::where('asset_id', $asset->id)->delete();
            $asset->delete();
        }

        //sign user out
        Auth::logout();

        //delete user
        $user->forceDelete();
    }
}
