<?php

use Illuminate\Http\Request;

Route::prefix('social')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::post('like/{type}/{id}', 'SocialController@likeItem');
        Route::post('unlike/{type}/{id}', 'SocialController@unlikeItem');
        Route::post('comment/{type}/{id}', 'SocialController@addComment');
        Route::post('share/{type}/{id}', 'SocialController@shareItem');
        Route::put('comment/{type}/{id}', 'SocialController@updateComment');

        Route::post('comment/delete', 'SocialController@deleteComment');
    });
    Route::get('/comments/{type}/{id}', 'SocialController@getCommentsForItem');
});

