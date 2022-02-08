<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Release;
use App\Track;

use DB;

class CartController extends Controller
{
    /**
     * Retrieve details about the items in a guest users cart
     *
     * @param Request $request
     * @return array
     */
    public function guestDetails(Request $request)
    {
        $products = [];
        foreach ($request->input('items') as $item) {
            switch ($item['type']) {
                case 'release':
                    $products[] = Release::with('tracks.artist')->where('id', $item['id'])->first();
                    break;
                case 'track':
                    $products[] = Track::with('artist')->find($item['id']);
                    break;
            }
        }
        return $products;
    }

    public function listItems(Request $request)
    {
        if (!$request->user()) {
            return;
        }
        $user = $request->user();

        $tracks = $user->cart_tracks->all();
        $releases = $user->cart_releases->all();

        return collect($tracks)->merge(collect($releases));
    }

    /**
     * Add an item to the users cart (registered users only)
     *
     * @param Request $request
     */
    public function addItem(Request $request)
    {
        if (!$request->user()) {
            return;
        }
        switch ($request->input('type')) {
            case 'release':
                $release = Release::findOrFail($request->input('id'));
                if ($release->tracks->count() > 0) { // Users shouldnt be able to buy a release with 0 tracks
                    $request->user()->cart_releases()->save($release, ['download_format' => $request->input('format')]);
                }

                break;
            case 'track':
                $track = Track::findOrFail($request->input('id'));
                $request->user()->cart_tracks()->save($track, ['download_format' => $request->input('format')]);
                break;
        }
    }

    /**
     * Remove an item from the users cart (registered users only)
     *
     * @param Request $request
     */
    public function removeItem(Request $request)
    {
        if (!$request->user()) {
            return;
        }
        switch ($request->input('type')) {
            case 'release':
                $release = Release::findOrFail($request->input('id'));
                $request->user()->cart_releases()->detach($release);
                break;
            case 'track':
                $track = Track::findOrFail($request->input('id'));
                $request->user()->cart_tracks()->detach($track);
                break;
        }
    }

    /**
     * Update a saved cart item format
     *
     * @param Request $request
     */
    public function changeItemFormat(Request $request)
    {
        if (!$request->user()) {
            return;
        }
        DB::table('cartables')
            ->where('user_id', $request->user()->id)
            ->where('cartable_id', $request->input('id'))
            ->where('cartable_type', $request->input('type'))
            ->update(['download_format' => $request->input('format')]);
    }
}
