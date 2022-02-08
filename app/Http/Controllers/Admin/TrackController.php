<?php

namespace App\Http\Controllers\Admin;

use App\Mail\TrackFrozen;
use App\Mail\TrackApproved;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Track;
use App\Release;
use Illuminate\Support\Facades\Mail;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Track $tracks)
    {
        $tracks = $tracks->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.tracks.index', compact('tracks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $release = Release::findOrFail($id);
        $tracks = $release->tracks;
        return view('admin.tracks.show', compact('tracks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $track = Track::findOrFail($id);
        return view('admin.tracks.edit', compact('track'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track, $id)
    {
        $track->destroy($id);
        return redirect('/admin/tracks');
    }

    public function freeze(Track $track, $id)
    {
        $track = $track->find($id);
        $track->status = 'frozen';
        $track->save();

        $track->release->takeOffline();

        Mail::to($track->release->uploader)->send(new TrackFrozen($track->release->uploader, $track));

        return back();
    }

    public function approve(Track $track, $id)
    {
        $track = $track->find($id);
        $track->status = 'approved';
        $track->save();

        $release = $track->release;
        $approved = $release->tracks->every(function ($track) {
            return $track->approved();
        });

        if ($approved) {
            $release->makeLive();
        }

        Mail::to($track->release->uploader)->send(new TrackApproved($track->release->uploader, $track));

        return back();
    }
}
