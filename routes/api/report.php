<?php

Route::middleware('auth')->group(function() {
    Route::post('/report', 'ReportController@report');
});