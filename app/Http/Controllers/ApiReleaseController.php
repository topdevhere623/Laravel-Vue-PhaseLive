<?php

namespace App\Http\Controllers;

use App\Release;
use Carbon\Carbon;
use App\Notification;
use Illuminate\Http\Request;
use App\Mail\ProcessingRelease;
use App\Notifications\NewRelease;
use Illuminate\Support\Facades\Mail;
use App\Rules\Audio;
use App\Track;

class ApiReleaseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->isFrozen()) {
            return response('Your account is currently frozen, so can not uploaded any new content.', 403);
        }

        if ($user->tracksCountThisMonth() > config('app.free_release_limit') && !$user->can('create unlimited releases')) {
            return response('You have already uploaded your track limit for this month', 422);
        }

        $data = $request->validate([
            'name' => 'required|max:50',
            'genres' => 'required|array',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'class' => 'required',
            'release_date' => 'required',
            'image' => 'required|image|max:5012',
            'tracks.*.name' => 'required|max:50',
            'tracks.*.bpm' => 'required|numeric',
            'tracks.*.key' => 'required',
            'tracks.*.file' => ['required', new Audio],
            'tracks.*.price' => 'required|integer|min:0',
        ]);

        $data['status'] = 'pending';
        $data['release_date'] = Carbon::createFromTimestampMs($data['release_date'])->addHour(1);
        $data['uploaded_by'] = $user->id;

        $release = Release::create($data);

        $release->saveCoverImage($request->file('image'), $release->name);
        $release->genres()->sync($request->get('genres'));

        /** Handle all tracks */
        foreach ($request->tracks as $key => $track) {
          $newTrack = Track::create([
            'name' => $track['name'],
            'bpm' => $track['bpm'],
            'key' => $track['key'],
            'price' => $track['price']
          ]);
          $newTrack->release_id = $release->id;
          $newTrack->uploaded_by = $request->user()->id;
          $newTrack->save();
          $newTrack->saveTrackFile($request->file('tracks')[$key]['file'], 'mp3');
        }

        Notification::notifyFollowers($request->user(), new NewRelease($release));

        Mail::to($request->user())->send(new ProcessingRelease($request->user(), $release));

        return Release::findOrFail($release->id);
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
    public function destroy($id)
    {
        //
    }
}
