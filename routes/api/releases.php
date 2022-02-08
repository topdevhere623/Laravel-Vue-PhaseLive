<?php

use App\Release;
use Illuminate\Database\Eloquent\Builder;

/**
 * Get latest releases with tracks by column
 * {filter?} column name
 * {count?} 'all' || integer
 **/
Route::get('/releases/tracks/latest/{filter?}/{count?}', function ($filter = 'release_date', $count = 15) {
    return paginateOrAll(Release::statuslive()->latest($filter)->with('tracks'), $count);
});

/**
 * Get featured releases
 * {count?} 'all' || integer
 **/
Route::get('/releases/tracks/featured/{count?}', function ($count = 15) {
    return paginateOrAll(Release::statuslive()->with('tracks'), $count);
});

/**
 * Get releases with tracks
 * {count?} 'all' || integer
 **/
Route::get('/releases/tracks/{count?}', function ($count = 15) {
    return paginateOrAll(Release::released()->with('tracks'), $count);
});

/**
 * Get latest releases by column
 * {filter?} column name
 * {count?} 'all' || integer
 **/
Route::get('/releases/latest/{filter?}/{count?}', function ($filter = 'release_date', $count = 15) {
    return Release::released()
        ->with(
            [
                'image',
                'uploader' => function ($query) {
                    return $query->select('name', 'id');
                }
            ]
        )
        ->latest($filter)
        ->paginate($count);
    // return Cache::remember('latest_releases:' . $filter . ':' . $count, now()->addHour(), function () use ($filter, $count) {

    //     return Release::released()
    //         ->with('image')
    //         ->latest($filter)
    //         ->paginate($count);
    // });
    //	return paginateOrAll(Release::statuslive()->latest($filter), $count);
});

/**
 * Get featured releases
 * {count?} 'all' || integer
 **/
Route::get('/releases/featured/{count?}', function ($count = 15) {
    return paginateOrAll(Release::released()->with('image')->whereHas('featuredDates', function (Builder $query) {
        $query->whereDate('featured_date', now()->startOfDay());
    }), $count);
});

/**
 * Get releases
 * {filter?} column name
 * {count?} 'all' || integer
 **/
Route::get('/releases/{count?}', function ($count = 15) {
    return paginateOrAll(Release::statuslive(), $count);
});

/**
 * Get release
 * {id} row id of release
 **/
Route::get('/release/{release}', function (Release $release) {
    return $release->load('uploader', 'image')->load([
        'tracks' => function ($query) {
            return $query->where('status', 'approved');
        }, 'tracks.artist'
    ]);
});

/**
 * Get release with tracks
 * {id} row id of release
 **/
Route::get('/release/{id}/tracks', function ($id) {
    return Release::with('tracks')->findOrFail($id);
});

Route::get('/release/featured', function ($id) {
    return Release::whereFeatured(1);
});

Route::post('/release/{id}/upload/tracks', 'ApiTrackController@store');
Route::post('/release/{id}/upload/track', 'ApiTrackController@storeSingle');
Route::post('/release/create', 'ApiReleaseController@store');
