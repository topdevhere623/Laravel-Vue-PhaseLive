<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Playlist;

class PlaylistController extends Controller
{
    public function list(Request $request)
    {
        return $request->user()->playlists;
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        $playlist = new Playlist([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);
        $request->user()->playlists()->save($playlist);
        return $playlist;
    }
}
