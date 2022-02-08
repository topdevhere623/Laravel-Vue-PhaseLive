<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\UploadedRelease;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;
use App\Action;

/**
 * Class RegisterUploadedReleaseAction
 *
 * Register (save) the action in the database when a user uploads a release
 *
 * @package App\Listeners\ActionRegisters
 */
class RegisterUploadedReleaseAction
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
     * @param  UploadedRelease  $event
     * @return void
     */
    public function handle(UploadedRelease $event)
    {
        $action = new Action([
            'created_by' => Auth::user()->id,
            'public' => false, // Shouldn't show on feed until release is approved
            'item_type' => 'release',
            'item_id' => $event->release->id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
