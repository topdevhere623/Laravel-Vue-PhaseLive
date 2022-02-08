<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Notification;
use App\Notifications\PostComment;
use App\Notifications\PostLiked;
use App\Notifications\PostShared;
use App\Notifications\TrackComment;
use App\Notifications\TrackLiked;
use App\Notifications\TrackShared;
use App\User;
use Auth;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function likeItem($type, $id)
    {
        $sociable = morphToModel($type, $id);
        $sociable->like();

        if ($type == 'post') {
            //get post owner and notify them that someone liked their post
            $owner = User::find($sociable->user_id);
            if ($owner->id != Auth::user()->id) {
                Notification::notifyUser($owner, new PostLiked(Auth::user()));
            }
        } elseif ($type == 'track') {
            $owner = $sociable->release->uploader;
            if ($owner->id != Auth::user()->id) {
                Notification::notifyUser($owner, new TrackLiked(Auth::user()));
            }
        }
    }

    public function unlikeItem($type, $id)
    {
        $sociable = morphToModel($type, $id);
        $sociable->unlike();
    }

    public function addComment(Request $request, $type, $id)
    {
        $sociable = morphToModel($type, $id);

        //get track owner and notify them that someone commented on their track
        if ($type == 'post') {
            //get post owner and notify them that someone liked their post
            $owner = User::find($sociable->user_id);
            if ($owner->id != $request->user()->id) {
                Notification::notifyUser($owner, new PostComment($request->user()));
            }
        } elseif ($type == 'track') {
            $owner = $sociable->release->uploader;
            if ($owner->id != $request->user()->id) {
                Notification::notifyUser($owner, new TrackComment($request->user()));
            }
        }

        return $sociable->addComment($request);
    }

    public function updateComment(Request $request, $type, $id)
    {
        $data = $request->validate([
            'body' => 'required|string',
        ]);

        $comment = Comment::find($id);

        if ($request->user()->id == $comment->user_id) {
            $comment = $comment->update([
                'body' => $data['body']
            ]);
        }

        return;
    }

    /**
     * 
     * Delete  comment
     */

    public function deleteComment(Request $request)
    {

        $comment = Comment::find($request->id);

        if ($request->user()->id == $comment->user_id) {
            $comment->delete();

            return response('comment deleted', 200);
        } else {
            return response('you cannot delete this comment as you are not the author', 500);
        }
    }

    public function shareItem(Request $request, $type, $id)
    {
        $shareable = morphToModel($type, $id);
        $data = $request->validate([
            'message' => 'nullable|string',
        ]);

        //get post owner and notify them that someone shared their post
        if ($type == 'post') {
            $owner = User::find($shareable->user_id);
            if ($owner->id != $request->user()->id) {
                Notification::notifyUser($owner, new PostShared($request->user()));
            }
        } elseif ($type == 'track') {
            $owner = $shareable->release->uploader;
            if ($owner->id != $request->user()->id) {
                Notification::notifyUser($owner, new TrackShared($request->user()));
            }
        }

        $request->user()->share($shareable, $data['message']);
    }

    public function getCommentsForItem($type, $id)
    {
        $commentable = morphToModel($type, $id);
        return $commentable->comments()
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'path');
                },
            ])
            ->orderByDesc('id')
            ->paginate(15);
    }
}
