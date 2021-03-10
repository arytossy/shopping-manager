<?php

namespace App\Broadcasting;

use App\Thread;
use App\User;

class ThreadChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return array|bool
     */
    public function join(User $user, Thread $thread)
    {
        return $user->belong_to($thread->id);
    }
}
