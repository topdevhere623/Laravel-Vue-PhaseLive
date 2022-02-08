<?php

namespace App\Policies;

use App\User;
use App\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Thread $thread)
    {
        if($thread->sender == $user || $thread->receiver == $user) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * For now this function is the same as view but is created incase we ever have different requirements for replying.
     *
     * @param User $user
     * @param Thread $thread
     * @return bool
     */
    public function reply(User $user, Thread $thread)
    {
        return $this->view($user, $thread);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Thread $thread)
    {
        //
    }

    public function delete(User $user, Thread $thread)
    {
        return false;
    }
}
