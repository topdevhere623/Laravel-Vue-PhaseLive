<?php

Route::middleware('auth')->post('/merch', 'MerchController@store');
Route::get('/merch', 'MerchController@index');
