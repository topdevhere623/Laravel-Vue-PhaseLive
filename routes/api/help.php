<?php

Route::prefix('help')->group(function (){
    Route::prefix('faq')->group(function () {
        Route::get('list', 'HelpController@listFaqs');
    });

    Route::post('contact', 'HelpController@postContactForm');
});

