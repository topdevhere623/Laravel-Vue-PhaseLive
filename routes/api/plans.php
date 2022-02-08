<?php

use App\Plan;

Route::get('plans', function () {
    return Plan::all();
});