<?php

namespace App\Listeners;

use App\Events\ThreadUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateThreadUpdateAt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadUpdated  $event
     * @return void
     */
    public function handle(ThreadUpdated $event)
    {
        $event->thread->updated_at = date('Y-m-d H:i:s');
        $event->thread->save();
    }
}
