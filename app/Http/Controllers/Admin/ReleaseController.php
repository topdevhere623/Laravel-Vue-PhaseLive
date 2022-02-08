<?php

namespace App\Http\Controllers\Admin;

use App\Events\SettleFeaturedDateOrderEvent;
use App\FeaturedReleaseDates;
use App\Mail\ReleaseApproved;
use App\Http\Controllers\Controller;
use App\Events\User\UploadedRelease as UserUploadedRelease;
use App\Action;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Release;
use App\Report;
use Illuminate\Support\Facades\Mail;

class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param null $filter
     */
    public function index(Request $request, $filter = null)
    {
        switch ($filter) {
            case 'live':
                $releases = Release::statusLive();
                break;
            case 'pending':
                $releases = Release::statusPending();
                break;
            case 'offline':
                $releases = Release::statusOffline();
                break;
            case 'trashed':
                $releases = Release::onlyTrashed();
                break;
            case 'featured':
                $releases = Release::featured();
                break;
            default:
                $releases = Release::query();
                break;
        }

        if ($request->has('search')) {
            $releases = $releases->search($request->search)->paginate(15);
        } else {
            $releases = $releases->paginate(15);
        }

        return view('admin.releases.index', compact('releases', 'filter'));
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

        switch ($action) {
            case 'bin':
                Release::destroy($selected);
                break;

            case 'restore':
                Release::onlyTrashed()->whereIn('id', $selected)->restore();
                break;
        }

        return redirect('/admin/releases');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $release = Release::findOrFail($id);


        return view('admin.releases.edit')->with([
            'release' => $release,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
            'featured' => 'required|boolean',
            'royalty_fee' => 'required|integer|min:0|max:100'
        ]);

        Release::findOrFail($id)->update($validated);

        return back();
    }

    public function approve($id)
    {
        $release = Release::findOrFail($id);
        $release->approve();

        //insert into actions when release is approved
        event(new UserUploadedRelease($release));
        //update created_by to the released user 
        Action::where('event_type', Action::USER_UPLOADED_RELEASE)->where('item_type', 'release')->where("item_id", $id)->update(['created_by' => $release->uploaded_by]);
        
        $release->tracks->each->approve();

        Mail::to($release->uploader)->send(new ReleaseApproved($release->uploader, $release));

        if ($release->isFeatured()) {
            $order = $release->featuredDates->last()->order;

            if (!now()->greaterThan(Carbon::parse($release->featuredDates->first()->featured_date))) {
                event(new SettleFeaturedDateOrderEvent($order));
            }
        }

        return back();
    }

    public function takeOffline($id)
    {
        $release = Release::findOrFail($id);
        $release->takeOffline();

        return back();
    }

    public function makeLive($id)
    {
        $release = Release::findOrFail($id);
        $release->makeLive();

        $release->tracks->each->approve();

        return back();
    }

    /**
     * Soft delete the object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $release = Release::findOrFail($id);
        $release->tracks()->delete();
        Report::whereReportableId($id)->delete();
        Release::destroy($id);

        return redirect('/admin/releases');
    }

    /**
     * Restore a soft deleted object
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Release::onlyTrashed()->where('id', $id)->restore();

        return redirect('/admin/releases');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Release::onlyTrashed()->where('id', $id)->forceDelete();

        return redirect('/admin/releases/trashed');
    }

    public function featuredDateApprove($id)
    {
        FeaturedReleaseDates::find($id)->approve();

        return back();
    }

    public function featuredDateDecline($id)
    {
        FeaturedReleaseDates::find($id)->decline();

        return back();
    }
}
