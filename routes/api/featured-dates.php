<?php

Route::get('price-per-featured-slot', function () {
    return setting('featured_spot_price');
});

Route::prefix('featured-dates')->group(function () {
    Route::get('', 'FeaturedDates@index');
    Route::post('create-setup-intent', 'CreateSetupIntent');
    Route::post('create', 'FeaturedDates@store');
    Route::get('fetch-order/{id}', 'FeaturedDatesOrderController');
    Route::post('failed-order/intent', 'FeaturedDates@failedOrderIntent');
});
