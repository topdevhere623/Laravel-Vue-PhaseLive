<?php

use Illuminate\Http\Request;

Route::prefix('cart')->group(function () {
    Route::post('guest/details', 'CartController@guestDetails');

    Route::get('item/list', 'CartController@listItems');
    Route::post('item/add', 'CartController@addItem');
    Route::post('item/remove', 'CartController@removeItem');
    Route::post('item/change', 'CartController@changeItemFormat');
});