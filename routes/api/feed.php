<?php

Route::get('/feed', 'FeedController@index');

Route::post('/feed/{id}/delete', 'FeedController@deleteAction');
