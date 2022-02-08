<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\UploadedVideo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;
use App\Action;

/**
 * Class RegisterUploadedVideoAction
 *
 * Register (save) the action in the database when a user uploads a video
 *
 * @package App\Listeners\ActionRegisters
 */
class RegisterUploadedVideoAction
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
     * @param  UploadedVideo  $event
     * @return void
     */
    public function handle(UploadedVideo $event)
    {
        $action = new Action([
            'created_by' => Auth::user()->id,
            'public' => false, // Shouldn't show on feed until release is approved
            'item_type' => 'video',
            'item_id' => $event->video->id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
