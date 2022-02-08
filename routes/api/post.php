<?php

use App\Post;

Route::get('/post/{id}', function ($id) {
    return Post::where('id', $id)->with('attachment')->withCount('comments', 'likes', 'shares')->first();
});
