<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\ReportSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;
use App\Action;

/**
 * Class RegisterReportAction
 *
 * Register (save) the action in the database when a user submits a new report
 *
 * @package App\Listeners\ActionRegisters
 */
class RegisterReportAction
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
     * @param  ReportSubmitted  $event
     * @return void
     */
    public function handle(ReportSubmitted $event)
    {
        $action = new Action([
            'created_by' => Auth::user()->id,
            'public' => false,
            'item_type' => 'report',
            'item_id' => $event->report->id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
