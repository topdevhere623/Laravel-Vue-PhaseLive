<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Release;
use App\Phase\Chart\Chart;
use App\Phase\Filter\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class ChartController extends Controller
{
    protected Chart $chart;
    protected Filter $filter;
    protected array $input;

    public function __construct(Request $request)
    {
        $this->input = $request->all();
    }

    private function reset()
    {
        $this->chart = new Chart(Release::class);
        $this->filter = new Filter($this->chart->get());
    }

    public function get($count = 7)
    {
        $genres = [];
        if (request()->has('genres')) {
            foreach (request('genres') as $genre) {
                array_push($genres, $genre['id']);
            }
        }
        $classes =  ['album', 'single', 'ep', 'compilation', 'sample'];
        if (isset($this->input['classes'])) {
            if (count($this->input['classes']) > 0) {
                $classes = [];
                foreach ($this->input['classes'] as $class) {
                    array_push($classes, $class['val']);
                }
            }
        }
        $nameForCache = 'chart_' . $count . implode('_', $genres) . '_' . implode('_', $classes);
        $results = Cache::remember($nameForCache . ':initial', now()->addHours(2), function () use ($classes, $genres, $count) {
            $results = [];
            foreach ($classes as $class) {
                $res = Release::select('id')
                    ->released()
                    ->where('class', $class)
                    ->whereHas('genres', function ($query) use ($genres) {
                        if (count($genres) > 0) {
                            $query->whereIn('genres.id', $genres);
                        }
                    })->limit($count)->get()->pluck('id');
                foreach ($res  as $item) {
                    array_push($results, $item);
                }
            }
            return $results;
        });

        $items = Cache::remember($nameForCache, now()->addHours(2), function () use ($results, $classes, $genres) {
            return Release::select([
                'id',
                'name',
                'status',
                'class',
                'image_id',
                'uploaded_by',
                'frozen_at',
                'release_date',
                'slug',
                'created_at',
            ])
                ->released()
                ->whereIn('id', $results)
                ->whereIn('class', $classes)
                ->whereHas('genres', function ($query) use ($genres) {
                    if (count($genres) > 0) {
                        $query->whereIn('genres.id', $genres);
                    }
                })
                ->with([
                    'uploader' => function ($query) {
                        $query->select('id', 'name', 'first_name', 'last_name', 'path');
                    },
                    'image' => function ($query) {
                        $query->select('id', 'created_at');
                    },
                    'tracks' => function ($query) {
                        $query->select([
                            'id', 'name', 'length', 'created_at', 'bpm', 'key', 'preview_id', 'asset_id',
                            'release_id', 'uploaded_by', 'status', 'slug'
                        ]);
                    },
                    'tracks.streamable',
                    'tracks.release' => function ($query) {
                        $query->select('id', 'name', 'created_at', 'class', 'uploaded_by', 'status', 'image_id');
                    },
                    'tracks.release.uploader' => function ($query) {
                        $query->select('id', 'name', 'path');
                    },
                    'tracks.preview',
                ])
                ->get()
                ->groupBy('class');
        });
        return $items;
    }

    private function getForClass($class, $count = null)
    {
        $this->reset();
        $this->filter->addClassFilter($class);
        if (isset($this->input['genres'])) {
            if (count($this->input['genres']) > 0) {
                foreach ($this->input['genres'] as $genreFilter) {
                    $genre = Genre::find($genreFilter['id']);
                    $this->filter->addGenreFilter($genre);
                }
            }
        }
        return $this->filter->get($count);
    }

    private function getForAllClasses($count = 12)
    {
        $items = Cache::remember('chart_items', now()->addDays(1), function () use ($count) {
            return [
                'album' => $this->getForClass('album', $count),
                'single' => $this->getForClass('single', $count),
                'ep' => $this->getForClass('ep', $count),
                'compilation' => $this->getForClass('compilation', $count),
                'sample' => $this->getForClass('sample', $count),
            ];
        });

        return $items;
    }
}
