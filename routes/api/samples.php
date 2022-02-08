<?php

use App\Genre;

Route::get('/samples/genre/{id}', function ($id) {
    $genre = Genre::find($id);
    // $items = $genre->samples()->latest('release_date')->paginate(15);
    $genre1 = Genre::with([
        'samples',
        'samples.tracks'
    ])->findOrFail($id);
    $items = $genre1->samples()->paginate(20);

    return compact('genre', 'items');
});
