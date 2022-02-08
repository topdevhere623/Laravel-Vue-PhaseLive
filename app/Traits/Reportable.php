<?php

namespace App\Traits;

use App\Report;

use App\Events\User\ReportSubmitted;

use Auth;

/**
 * Trait Reportable
 *
 * Applied to classes that have the ability to be reported
 *
 * @package App\Traits
 */
trait Reportable
{
    public function reports()
    {
        return $this->morphMany('App\Report', 'reportable');
    }

    public function report($message, $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }
        // Check the user has not reported this reportable already
        $report = Report::where('user_id', $user->id)
            ->where('reportable_type', $this->type)
            ->where('reportable_id', $this->id)
            ->first();

        if (!$report) {
            $report = new Report([
                'user_id' => $user->id,
                'reportable_type' => $this->type,
                'reportable_id' => $this->id,
                'acknowledged' => false,
                'message' => $message,
            ]);
            $report->save();
            event(new ReportSubmitted($report));
            return [
                'success' => true,
                'report' => $report,
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Already reported',
            ];
        }
    }
}
