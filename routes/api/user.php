<?php

use App\User;
use Illuminate\Http\Request;

Route::prefix('user')->group(function () {

    Route::get('notifications/{id}', 'UserController@getNotificationsForUser')->middleware('auth');
    Route::get('notifications/read/{id}', 'UserController@MarkNotificationRead')->middleware('auth');
    //    Route::get('search', function (Request $request) {
    //        return User::select('id', 'name')->where('name', 'LIKE', '%' . $request->get('name') . '%')->limit(5)->get();
    //    });
    Route::get('search', function (Request $request) {
        return User::select('id', 'name')
            ->where('name', 'LIKE', '%' . $request->get('name') . '%')
            ->where('id', '!=', Auth::user()->id)
            ->limit(5)
            ->get();
    });

    Route::post('track', 'TrackPlayController');

    Route::get('follow/{targetid}', 'UserController@follow')->middleware('auth');

    Route::get('unfollow/{targetid}', 'UserController@unfollow')->middleware('auth');

    Route::post('upload/avatar', 'UserController@uploadAvatar')->middleware('auth');

    Route::post('upload/banner', 'UserController@uploadBanner')->middleware('auth');

    Route::delete('banner', 'UserController@deleteBanner')->middleware('auth');

    //Route::get('posts/from/{userid}', 'UserController@getPostsFromUser');
    Route::get('{userid}/posts', 'UserController@getPostsForUser');
    Route::get('{userid}/events', 'UserController@getEventsForUser');
    Route::get('{userid}/activity', 'UserController@getActivityForUser');
    Route::get('{userid}/merch', 'UserController@getMerchForUser');
    Route::get('{userid}/releases', 'UserController@getReleasesForUser');
    Route::get('{userid}/videos', 'UserController@getVideosForUser');

    Route::get('feed', 'UserController@getFeed')->middleware('auth');
    Route::post('posts/add', 'UserController@postStatusUpdate')->middleware('auth');
    Route::post('events/add', 'UserController@postNewEvent')->middleware('auth');
    Route::get('{id}/favourites', 'FavouritesController@index')->middleware('auth');
    Route::get('followed', 'FollowController@index')->middleware('auth');

    Route::get('{path?}', 'UserController@getUser');

    Route::get('destroy/{id}', 'UserController@destroy');
    Route::get('delete/{id}', 'UserController@delete');
    Route::post('restore', 'UserController@restore');
});
