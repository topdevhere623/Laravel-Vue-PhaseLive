<?php

Route::prefix('playlist')->middleware('auth')->namespace('Account')->group(function () {
    Route::get('list', 'PlaylistController@list');
    Route::post('create', 'PlaylistController@create');
});