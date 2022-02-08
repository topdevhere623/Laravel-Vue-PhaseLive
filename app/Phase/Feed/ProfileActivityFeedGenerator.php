<?php

namespace App\Phase\Feed;

use App\Post;
use App\User;
use App\Action;

/**
 * Class ProfileActivityFeedGenerator
 *
 * Return a collection of actions that can be used to make an activity feed for a user.
 *
 * @package App\Phase\Feed
 */
class ProfileActivityFeedGenerator
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get all actions which should be displayed on the users profile
     *
     * @return mixed
     */
    public function getActionsForProfile()
    {
        $userActions = $this->user->actions;

        return $userActions
            ->merge($this->getActionsForPostsTargetedAtUser())
            ->sortByDesc('created_at')
            ->values();
    }

    /**
     * Get all actions which relate to posts targeted at the user
     *
     * @return \Illuminate\Support\Collection
     */
    public function getActionsForPostsTargetedAtUser()
    {
        $posts = Post::targetedAt($this->user)
            ->withCount('comments', 'likes', 'shares')
            ->get();

        $postsActions = collect();
        foreach ($posts as $post) {
            $postAction = Action::where('item_type', 'post')
                ->where('item_id', $post->id)
                ->first();

            $postsActions->push($postAction);
        }
        return $postsActions;
    }
}
