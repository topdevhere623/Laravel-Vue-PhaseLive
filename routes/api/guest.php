<?php

Route::prefix('/auth')->group(function () {
    Route::post('login', 'Auth\LoginController@attempt');
    Route::get('logout', 'Auth\LoginController@logout');

    Route::post('register/{type}', 'Auth\RegisterController@register');
    Route::post('marketplace/create', 'Auth\MarketplaceController@store');
    Route::post('marketplace/update', 'Auth\MarketplaceController@update');
//    Route::post('register/music_fan', 'Auth\RegisterController@registerMusicFan');
//    Route::post('register/pro_standard', 'Auth\RegisterController@registerProfessionalStandard');
//    Route::post('register/pro_premium', 'Auth\RegisterController@registerProfessionalPremium');
});

Route::post('/mailing-list', 'MailingListController@store');

Route::get('/routes', function () {
	return getRoutes();
});
