<?php

use Illuminate\Http\Request;

Route::prefix('event')->middleware('auth')->group(function () {
    Route::post('create', 'EventController@create');
    Route::get('{user_id}/list', 'EventController@listForUser');
    Route::get('{event_id}/get', 'EventController@get');
    Route::post('{event_id}/update', 'EventController@update');
    Route::post('{event_id}/delete', 'EventController@delete');
});