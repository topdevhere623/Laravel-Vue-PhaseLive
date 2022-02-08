<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\PostedStatusUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;
use App\Action;

/**
 * Class RegisterPostedStatusUpdateAction
 *
 * Register (save) the action in the database when a user creates new post (status update)
 *
 * @package App\Listeners\ActionRegisters
 */
class RegisterPostedStatusUpdateAction
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
     * @param  PostedStatusUpdate  $event
     * @return void
     */
    public function handle(PostedStatusUpdate $event)
    {
        $action = new Action([
            'created_by' => Auth::user()->id,
            'public' => true,
            'item_type' => 'post',
            'item_id' => $event->post->id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
