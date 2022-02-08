<?php

namespace App\Http\Controllers;

use App\User;
use App\Track;
use App\Jobs\TrackPlays;
use Illuminate\Http\Request;

class TrackPlayController extends Controller
{
    public function __invoke(Request $request)
    {
        TrackPlays::dispatch(Track::find($request->track['id']), User::find($request->user));
    }
}
