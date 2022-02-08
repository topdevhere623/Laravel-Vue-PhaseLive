<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Storage;
use App\Asset;
use App\Track;
use App\Release;
use Illuminate\Support\Facades\Auth;

class ApiTrackController extends Controller
{
    private $release;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    //    public function store(Request $request, $id)
    //    {
    //        $validator = Validator::make($request->all(), [
    //            'tracks.*.name' => 'required',
    //            'tracks.*.length' => 'required',
    //            'tracks.*.bpm' => 'required',
    //            'tracks.*.key' => 'required',
    //            'tracks.*.file' => 'required'
    //        ]);
    //
    //        if ($validator->fails())
    //        {
    //            return $validator->errors();
    //        }
    //
    //        $this->release = Release::findOrFail($id);
    //
    //        foreach ($request->tracks as $track)
    //        {
    //            $track = collect($track);
    //
    //            $trackModel = Track::create($track->only(['name', 'length', 'bpm', 'key'])->toArray());
    //            $trackModel->release_id = $this->release->id;
    //            $trackModel->file_id = $this->uploadTrackAudio($track->get('file'), $trackModel);
    //            $trackModel->save();
    //        }
    //
    //        return Release::findOrFail($id);
    //    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeSingle(Request $request, $id)
    {
        $request->validate([
          'name' => 'required|max:50',
          'bpm' => 'required',
          'key' => 'required',
          'file' => 'required|mimes:audio/mpeg,mpga,mp3,wav',
          'price' => 'required|integer|min:0',
        ]);

        $this->release = Release::findOrFail($id);

        $track = Track::create($request->only(['name', 'bpm', 'key', 'price']));
        $track->release_id = $id;
        $track->uploaded_by = $request->user()->id;
        $track->save();
        $track->saveTrackFile($request->file('file'), 'mp3');

        return Release::findOrFail($id);
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

    protected function uploadTrackAudio($file, $track)
    {
        $file = Storage::disk('local')->putFileAs(
            "releases/{$this->release->id}",
            $file,
            $track->id . '.' . $file->extension()
        );

        $asset = Asset::create(['path' => $file]);

        return $asset->id;
    }
}
