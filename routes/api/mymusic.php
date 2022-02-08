<?php

Route::prefix('mymusic')->middleware('auth')->group(function () {
    Route::get('/', 'APIMyMusicController@getMyMusic');
    Route::get('/download/{format}/{trackid}', 'APIMyMusicController@downloadTrack');
    //Route::get('/stream/{trackid}', 'APIMyMusicController@streamTrack');
});
