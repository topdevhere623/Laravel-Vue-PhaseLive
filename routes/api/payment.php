<?php


Route::prefix('payment')->group(function() {
    Route::get('client_secret', 'PaymentController@getClientSecret');
});
