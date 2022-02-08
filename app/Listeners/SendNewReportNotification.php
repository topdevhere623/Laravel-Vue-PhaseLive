<?php

namespace App\Listeners;

use App\Events\User\ReportSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\UserReportSubmitted as UserReportSubmittedMail;

use App\User;

/**
 * Class SendNewReportNotification
 *
 * Send an email to all users who have the 'access reports' permission, informing them that a new report has been
 * submitted
 *
 * @package App\Listeners
 */
class SendNewReportNotification
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
        $users = User::permission('access reports')->get();

        foreach ($users as $user) {
            Mail::to($user)
                ->send(new UserReportSubmittedMail($event->report));
        }
    }
}
