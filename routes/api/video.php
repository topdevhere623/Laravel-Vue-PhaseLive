<?php

Route::prefix('video')->group(function() {
    Route::get('{id}', 'VideoController@getVideo');
    Route::post('create', 'VideoController@createVideo');
    Route::get('upload', 'VideoController@uploadFile');
    Route::post('upload', 'VideoController@uploadFile');
    Route::post('save/{videoid}', 'VideoController@save');
});