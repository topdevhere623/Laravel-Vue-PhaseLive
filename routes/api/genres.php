<?php

use App\Genre;
use App\Release;

Route::get('/genres/{count?}', function ($count = 'all') {
    return Cache::remember('genres:' . $count, now()->addDays(14), function () use ($count) {
        if (!is_numeric($count) || $count == 'all') {
            //return Genre::all();
            return Genre::paginate(count(Genre::all()));
        }

        return Genre::paginate($count);
    });
});

Route::get('/genre/{genre}', function (Genre $genre) {
    $items = Release::whereHas('genres', function ($query) use ($genre) {
        $query->where('genres.id', $genre->id);
    })->released()
        ->withCount([
            'comments as comments_count', 'likes as likes_count', 'shares as shares_count'
        ])
        ->with([
            'image',
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
        ])->paginate(20);
    // $items = $genre->releases()->released()->paginate(20);

    return compact('genre', 'items');
});
