<?php

namespace App\Http\Controllers;

use App\Download;
use App\Order;
use Exception;
use Illuminate\Http\Request;

use App\Track;
use App\User;
use Storage;
use File;

class APIMyMusicController extends Controller
{
    public function getMyMusic(Request $request)
    {
        $mymusic = collect();
        $userOrders = Order::where('purchaser_id', $request->user()->id)
            ->where('status', 'complete')
            ->orderByDesc('created_at')
            ->get()->pluck('id');
        $downloads = Download::whereIn('order_id', $userOrders)
            ->with([
                'track',
                'track.release' => function ($query) {
                    $query->select('id', 'name', 'slug', 'featured', 'royalty_fee', 'created_at', 'class', 'uploaded_by', 'status', 'image_id');
                },
                'track.release.uploader' => function ($query) {
                    $query->select('id', 'name', 'path');
                },
                'track.release.image',
                'track.streamable'
            ])
            ->get()->groupBy('track.release_id');
        return $downloads;
        // Remove items where the user has reached the download limit
        //        for ($i = 0; $i < count($mymusic); $i++) {
        //            if ($mymusic[$i]->count >= 3) {
        //                $mymusic->forget($i);
        //            }
        //        }
    }

    public function downloadTrack(Request $request, $format, $trackid)
    {
        $download = $this->userCanDownloadTrack($request->user(), $format, $trackid);

        if ($download) {
            try {
                $url = $download->track->asset->files->filter(function ($file) use ($format) {
                    return str_contains($file->mime, $format);
                })->first()->tempUrl(10);

                $download->count += 1;
                $download->save();

                return redirect($url);
            } catch (Exception $e) {
                return response('File does not exist', 403);
            }
        } else {
            return response(null, 403);
        }
    }

    /*
    public function streamTrack(Request $request, $trackid) {
        $download = $this->userCanDownloadTrack($request->user(), null, $trackid);
        if($download) {
            $track = Track::findOrFail($trackid);
            $filename = 'public/releases/' . $track->release->id . '/' . $track->id . '.' . $download->format;
            $file = Storage::disk('local')->get($filename);
            //$filesize = (int) File::size($filename);

            return response($file, 200)
                ->header('Content-Type', 'audio/mpeg')
                ->header('Content-Length', '12231373')
                ->header('Content-Range', 'bytes 3211264-15442636/15442637');
        } else {
            return response(null, 403);
        }
    }
    */

    private function userCanDownloadTrack($user, $format, $trackid)
    {
        $track = Track::findOrFail($trackid);

        foreach ($user->orders->where('status', 'complete') as $order) {
            foreach ($order->downloads as $download) {
                // IF requested track matches current track in iteration
                // AND they have downloaded the track less than three times
                // AND the download format matches the requested download format
                if ($download->track->id === $track->id && $download->count < 5 && $download->format == $format) {
                    return $download;
                } elseif ($format == null) { // If no format is specified, we don't check if the download format matches
                    if ($download->track->id === $track->id && $download->count < 5) {
                        return $download;
                    }
                }
            }
        }

        return false;
    }
}
