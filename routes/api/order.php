<?php

Route::prefix('order')->middleware('auth')->group(function () {
    Route::get('/list/items/{count?}', 'OrderController@listWithItems');
    Route::get('/list/{count?}', 'OrderController@list');
    Route::post('/create', 'OrderController@create');

    Route::post('/payment/intent', 'ProcessPaymentController@paymentIntent');
    Route::post('/featured/payment/intent', 'ProcessPaymentController@featuredPaymentIntent');
});
