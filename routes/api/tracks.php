<?php

use App\Track;

Route::get('/tracks/{count?}', function ($count = 15) {
	if (!is_numeric($count) || $count == 'all')
		return Track::all();

	return Track::paginate($count);
});

Route::get('/track/{track}', function (Track $track) {
	return $track->load([
		'preview', 'release', 'release.uploader', 'release.image'
	]);
});
