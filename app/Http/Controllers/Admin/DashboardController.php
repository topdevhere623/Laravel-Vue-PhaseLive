<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Release;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param null $filter
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $filter = null)
    {
        if ($request->has('search') && $request->has('model')) {
            return redirect('/admin/' . $request->model . '?search=' . $request->search);
        }

//        switch ($filter) {
//            case 'live':
//                $releases = Release::statusLive();
//                break;
//            case 'pending':
//                $releases = Release::statusPending();
//                break;
//            case 'offline':
//                $releases = Release::statusOffline();
//                break;
//            case 'trashed':
//                $releases = Release::onlyTrashed();
//                break;
//            default:
//                $releases = new Release;
//                break;
//        }

        $releases = Release::statusPending()->orderBy('release_date', 'desc');
        $releases = $releases->paginate(15);
        $users = User::where('approved_at', null)->paginate();

        return view('admin.dashboard')->with([
            'releases' => $releases,
            'users' => $users,
            'filter' => $filter,
        ]);
    }

    /**
     * Handle bulk actions
     *
     * @param \Illuminate\Http\Request $request
     *
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
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
            'featured' => 'required|boolean',
        ]);

        Release::findOrFail($id)->update($validated);

        return back();
    }

    public function approve($id)
    {
        $release = Release::findOrFail($id);
        $release->approve();
        return redirect('/admin/releases/pending');
    }

    public function takeOffline($id)
    {
        $release = Release::findOrFail($id);
        $release->takeOffline();
        return redirect('/admin/releases/live');
    }

    public function makeLive($id)
    {
        $release = Release::findOrFail($id);
        $release->makeLive();
        return redirect('/admin/releases/offline');
    }

    /**
     * Soft delete the object
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Release::destroy($id);

        return redirect('/admin/releases');
    }

    /**
     * Restore a soft deleted object
     *
     * @param int $id
     *
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Release::onlyTrashed()->where('id', $id)->forceDelete();

        return redirect('/admin/releases/trashed');
    }
}
