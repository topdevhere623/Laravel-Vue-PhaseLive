<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Phase\Stats\Sales\TotalVolume;
use App\Phase\Stats\Social\TotalLikes;
use App\Phase\Stats\Sales\TotalRevenue;

class StatsController extends Controller
{
    public function getRevenueForAllReleases(Request $request)
    {
        $totalRevenue = new TotalRevenue();

        return $totalRevenue->forSellables(
            $request->user()->sales()->where('item_type', 'release')->get()
        );
    }

    public function getRevenueForAllTracks(Request $request)
    {
        $totalRevenue = new TotalRevenue();

        return $totalRevenue->forSellables(
            $request->user()->sales()->where('item_type', 'track')->get()
        );
    }

    public function getVolumeForAllReleases(Request $request)
    {
        $totalVolume = new TotalVolume();

        return $totalVolume->forSellables(
            $request->user()->sales()->where('item_type', 'release')->get()
        );
    }

    public function getVolumeForAllTracks(Request $request)
    {
        $totalVolume = new TotalVolume();

        return $totalVolume->forSellables(
            $request->user()->sales()->where('item_type', 'track')->get()
        );
    }

    public function getLikesForAllReleases(Request $request)
    {
        $totalLikes = new TotalLikes();

        return $totalLikes->forLikeables($request->user()->releases);
    }

    public function getLikesForAllTracks(Request $request)
    {
        // $tracks = collect();
        // foreach ($request->user()->releases as $release) {
        //     $tracks = $tracks->concat($release->tracks);
        // }
        $tracks = $request->user()->tracks;

        $totalLikes = new TotalLikes();
        return $totalLikes->forLikeables($tracks);
    }
}
