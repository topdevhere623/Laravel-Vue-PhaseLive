<?php

namespace App\Http\Controllers;

use App\Asset;
use App\File;
use App\Track;
use App\Genre;
use App\Release;
use App\Phase\Filter\Filter;
use Illuminate\Support\Facades\Cache;

class DiscoverController extends Controller
{
    protected $filter;

    public function get()
    {
        $genres = [];
        if (request()->has('genres')) {
            foreach (request('genres') as $genre) {
                array_push($genres, $genre['id']);
            }
        }
        $classes = [];
        if (request()->has('classes')) {
            foreach (request('classes') as $class) {
                array_push($classes, $class['val']);
            }
        }
        $filter = '';
        if (request()->has('filter')) {
            if (count(request('filter')) > 0) {
                $filter = request('filter')[0];
            }
        }
        $column = $this->getFilterOrderBy($filter)['column'];
        $direction = $this->getFilterOrderBy($filter)['direction'];
        $release = Release::select([
            'id', 'release_date', 'name', 'slug', 'frozen_at', 'status', 'image_id', 'uploaded_by', 'created_at'
        ])
            ->released()
            ->whereHas('genres', function ($query) use ($genres) {
                if (count($genres) > 0) {
                    $query->whereIn('genres.id', $genres);
                }
            })->whereHas('tracks', function ($query) use ($classes) {
                if (request()->has('bpm')) {
                    $query->whereBetween('bpm', [request('bpm')[0], request('bpm')[1]]);
                }
                if (count($classes) > 0) {
                    $query->whereHas('release', function ($q) use ($classes) {
                        $q->whereIn('class', $classes);
                    });
                }
            })
            ->with([
                'image',
                'uploader' => function ($query) {
                    $query->select('id', 'name', 'first_name', 'last_name', 'path');
                },
                'tracks',
                'tracks.preview',
                'tracks.release' => function ($query) {
                    $query->select('id', 'name', 'created_at', 'class', 'uploaded_by', 'status');
                },
                'tracks.release.uploader' => function ($query) {
                    $query->select('id', 'name', 'path');
                },
            ])
            ->withCount([
                'comments as comments_count',
                'likes as likes_count',
                'shares as shares_count'
            ])
            ->orderBy($column, $direction)
            ->paginate(15);

        return $release;
    }

    private function getFilterOrderBy($key = '')
    {
        $order = '';
        if ($key) {
            switch (strtolower($key)) {
                case 'latest':
                    $order = [
                        'column' => 'release_date',
                        'direction' => 'desc'
                    ];
                    break;
                case 'popular':
                    $order = [
                        'column' => 'score',
                        'direction' => 'desc'
                    ];
                    break;
                case 'labels':
                    $order = [
                        'column' => 'created_at',
                        'direction' => 'desc'
                    ];
                    break;
                case 'producers':
                    $order = [
                        'column' => 'uploaded_by',
                        'direction' => 'asc'
                    ];
                    break;
                default:
                    $order = [
                        'column' => 'release_date',
                        'direction' => 'desc'
                    ];
                    break;
            }
        } else {
            $order = [
                'column' => 'created_at',
                'direction' => 'desc'
            ];
        }
        return $order;
    }
}
