<?php

namespace App\Phase\Filter;

use App\Genre;

use Log;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class Filter
 *
 * Given a collection of items, return a filtered collection where items conform to a set of specified filters.
 *
 * @package App\Phase\Filter
 */
class Filter
{
    private $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * Get all items which remain after the filters have been added
     *
     * @param  null  $count
     *
     * @return mixed
     */
    public function get($count = null)
    {
        return ($count ? $this->items->take($count) : $this->items);
    }

    /**
     * Paginate the items which remain after the filters have been added
     *
     * @param  int  $perPage
     * @param  null  $page
     * @param  array  $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $this->items = $this->items instanceof Collection ? $this->items : Collection::make($this->items);

        return new LengthAwarePaginator(
            array_values($this->items->forPage($page, $perPage)->toArray()),
            $this->items->count(),
            $perPage,
            $page,
            $options
        );
    }

    /**
     * Remove all items which do not have the specified genre attached
     *
     * @param  Genre  $filterGenre
     *
     * @return $this
     */
    public function addGenreFilter(Genre $filterGenre)
    {
        $this->items = $this->items->filter(function ($item) use ($filterGenre) {
            foreach ($item->genres as $genre) {
                if ($genre->id == $filterGenre->id) {
                    return true;
                }
            }
            return false;
        })->values();
        return $this;
    }

    /**
     * Remove all items which are not of the specified class (e.g. 'album', 'single' etc.)
     *
     * @param $filterClass
     *
     * @return $this
     */
    public function addClassFilter($filterClass)
    {
        $this->items = $this->items->filter(function ($item) use ($filterClass) {
            if ($item->class == Str::singular($filterClass)) { // Allow pluralised e.g. albums and album will both work
                return true;
            }
            return false;
        })->values();

        return $this;
    }

    /**
     * Remove all items which are not of the specified key (e.g. 'a', 'c+')
     *
     * @param $filterKey
     *
     * @return $this
     */
    public function addKeyFilter($filterKey)
    {
        // $this->items = $this->items->filter(function($item) use ($filterKey) {
        //     if($item->key == $filterKey) {
        //         return true;
        //     }

        //     return true;
        // });

        // $tracks = Track::all();
        $filterKey = collect($filterKey)->flatten();

        if (count($filterKey) > 0) {
            $this->items = $this->items->whereIn('key', $filterKey);
        }


        return $this;
    }

    /**
     * Remove all items which are not of the selected BPM
     *
     * @param $filterKey
     *
     * @return $this
     */
    public function addBpmFilter($minbpm, $maxbpm)
    {

        $this->items = $this->items->filter(function ($item) use ($minbpm, $maxbpm) {
            foreach ($item->tracks as $track) {
                if ($track->bpm >= $minbpm && $track->bpm <= $maxbpm) {
                    return true;
                }
            }
            return false;
        });
        return $this;
    }


    /**
     * Filter the items by the selected filter.
     *
     * @param $filter
     *
     * @return $this
     */
    public function addFilterFilter($filter)
    {
        switch (strtolower($filter)) {
            case 'latest':
                $this->items = $this->items->sortByDesc('release_date')->values();
                break;
            case 'popular':
                $this->items = $this->items->sortByDesc('score')->values();
                break;
            case 'labels':
                break;
            case 'producers':
                $this->items = $this->items->sortBy('uploaded_by')->values();
                break;
        }

        return $this;
    }
}
