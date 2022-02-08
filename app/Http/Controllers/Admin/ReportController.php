<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateReportRequest;
use App\Phase\Report as PhaseReport;
use App\Report;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param null $filter
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $filter = null)
    {
        switch ($filter) {
            case 'acknowledged':
                $reports = Report::acknowledged();
                break;
            case 'unacknowledged':
                $reports = Report::unAcknowledged();
                break;
            default:
                $reports = new Report;
                break;
        }

        if ($request->has('search')) {
            $reports = $reports->search($request->search)->orderby('created_at')->paginate(15);
        } else {
            $reports = $reports->orderby('created_at')->paginate(15);
        }

        return view('admin.reports.index')->with([
            'reports' => $reports,
            'filter' => $filter
        ]);
    }

    /**
     * Store a new report as a site administrator
     *
     * @param   CreateReportRequest  $request
     */
    public function store(CreateReportRequest $request)
    {
        $reportable = PhaseReport::getReportable($request->type, $request->id);
        Report::create([
            'user_id' => $request->user()->id,
            'reportable_type' => $reportable->type,
            'reportable_id' => $reportable->id,
            'acknowledged' => true, // Doesn't need to be checked by another admin
            'message' => 'Reported by admin'
        ]);

        return redirect('/admin/reports/acknowledged');
    }

    /**
     * Handle bulk actions
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkAction(Request $request)
    {
        $action = $request->get('actions');
        $selected = $request->get('selected');

        if (empty($selected)) {
            return back();
        }

        switch($action)
        {
            case 'bin':
            Report::where('id', $selected)->forceDelete();
            break;
        }

        //        switch ($action)
        //        {
        //            case 'bin':
        //                Comment::destroy($selected);
        //                break;
        //
        //            case 'restore':
        //                Comment::onlyTrashed()->whereIn('id', $selected)->restore();
        //                break;
        //        }

        return redirect('/admin/reports');
    }

    /**
     * Show the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $report = Report::findOrFail($id);

        return view('admin.reports.view')->with([
            'report' => $report,
        ]);
    }

    public function acknowledge($id)
    {
        $report = Report::findOrFail($id);

        $report->acknowledge();

        return redirect('/admin/reports/acknowledged');
    }

    public function unacknowledge($id)
    {
        $report = Report::findOrFail($id);

        $report->acknowledge(false);


        return redirect('/admin/reports/unacknowledged');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Report::where('id', $id)->forceDelete();

        return redirect('/admin/reports');
    }
}
