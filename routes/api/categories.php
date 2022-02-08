<?php

use App\Category;

Route::get('/categories/{count?}', function ($count = 15) {
	return paginateOrAll(new Category, $count);
});