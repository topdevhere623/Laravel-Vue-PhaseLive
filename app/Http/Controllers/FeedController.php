<?php

namespace App\Http\Controllers;

use App\Post;
use App\Action;
use App\Track;
use App\Video;
use App\Event;
use App\Merch;
use App\Genre;
use App\Release;
use App\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FeedController extends Controller
{
    protected $input;

    public function __construct(Request $request)
    {
        $this->input = $request->all();
    }

    /**
     *
     */
    public function index()
    {
        // 6 hours
        $cache_seconds = now()->addMinutes(30);
        $cache_token = 'feed';

        try {

            $cached_result = Cache::remember($cache_token, $cache_seconds, function () {

                $default_limit = 10;
                $collection = collect([]);

                Release::statuslive()->with([
                    'image',
                    'uploader' => function ($query) {
                        $query->select('id', 'name', 'path');
                    },
                ])->withCount('shares', 'comments', 'likes')->limit(10)->get()->each(function ($item) use (&$collection) {
                    $item->component = 'feed-release';
                    $item->type = 'release';
                    $collection->push($item);
                });
                Track::namenotnull()->with([
                    'preview',
                    'release',
                    'release.image',
                    'release.uploader' => function ($query) {
                        $query->select('id', 'name', 'path');
                    },
                ])->with('asset')->limit(10)->get()->each(function ($item) use (&$collection) {
                    $item->component = 'feed-track';
                    $item->type = 'track';
                    $collection->push($item);
                });
                if (auth()->check()) {
                    if (Auth::user()->can('upload videos')) {
                        Video::published()->limit(8)->get()->each(function ($item) use (&$collection) {
                            $item->component = 'feed-video';
                            $item->type = 'video';
                            $collection->push($item);
                        });
                    }

                    if (Auth::user()->can('add events')) {
                        Event::datenotnull()->withCount('shares')->limit(7)->get()->each(function ($item) use (&$collection) {
                            $item->component = 'feed-event';
                            $item->type = 'event';
                            $collection->push($item);
                        });
                    }

                    if (Auth::user()->can('add merch')) {
                        Merch::namenotnull()->limit(6)->get()->each(function ($item) use (&$collection) {
                            $item->component = 'feed-merch';
                            $item->type = 'merch';
                            $collection->push($item);
                        });
                    }
                }

                Post::bodynotnull()->withCount(['comments', 'likes', 'shares'])->limit(7)->get()->each(function ($item) use (&$collection) {
                    $item->component = 'feed-post';
                    $item->type = 'post';
                    $collection->push($item);
                });

                Genre::namenotnull()->limit(8)->get()->each(function ($item) use (&$collection) {
                    $item->component = 'feed-genre';
                    $item->type = 'genre';
                    $collection->push($item);
                });

                //                Playlist::namenotnull()->limit(7)->get()->each( function( $item ) use ( &$collection ) {
                //                    $item->component = 'feed-playlist';
                //                    $item->type = 'playlist';
                //                    $collection->push($item);
                //                });

                // TODO - Charts.

                // We have a flat array with each item assigned a frontend component.
                return $collection;
            });
        } catch (\Exception $e) {
            // Log::info("FeedController:index -> " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return ['data' => $cached_result];
    }


    public function deleteAction($id)
    {
        $types = [
            'post' => 'App\Post',
            'video' => 'App\Video',
        ];

        $action = Action::find($id);
        $actionItem = $action->item_id;
        $type = $types[$action->item_type];
        $item = $type::find($actionItem);

        $type::destroy($item->id);
        Action::destroy($id);

        $type = ucfirst($action->item_type);

        return "This {$type} Has Been Deleted";
    }
}
