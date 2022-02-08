<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Notifications\PostReported;
use App\Notifications\TrackReported;
use App\Phase\Report;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'id' => 'required|integer',
            'message' => 'required|string',
        ]);

        $reportable = Report::getReportable($validated['type'], $validated['id']);

        if ($validated['type'] == 'track') {
            if ($reportable->release->uploader->id != $request->user()->id) {
                Notification::notifyUser($reportable->release->uploader, new TrackReported($reportable));
            }
        } elseif ($validated['type'] == 'post') {
            $owner = User::find($reportable->user_id);
            if ($owner->id != $request->user()->id) {
                Notification::notifyUser($owner, new PostReported($reportable));
            }
        }

        if (!$reportable) {
            return [
                'success' => false,
                'message' => 'Invalid Reportable',
            ];
        } else {
            return $reportable->report($validated['message']);
        }
    }
}
