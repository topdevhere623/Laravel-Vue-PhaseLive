<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group.
|
*/

Route::namespace('Admin')->group(function () {
    Route::get('/', 'DashboardController@index');

    Route::get('/assets', 'AssetController@index');

    Route::prefix('pages')->group(function () {
        Route::get('edit/{id}', 'PageController@edit');
        Route::patch('edit/{id}', 'PageController@update');
        Route::get('create/', 'PageController@create');
        Route::post('create/', 'PageController@store');
        Route::get('delete/{id}', 'PageController@delete');
        Route::get('restore/{id}', 'PageController@restore');
        Route::get('destroy/{id}', 'PageController@destroy');
        Route::post('{type?}', 'PageController@bulkAction');
        Route::get('{type?}', 'PageController@index');
    });

    Route::prefix('orders')->group(function () {
        Route::get('{type?}', 'OrderController@index');
        Route::get('/{type}/{id}', 'OrderController@update');
    });

    Route::prefix('comments')->group(function () {
        Route::get('edit/{id}', 'CommentController@edit');
        Route::get('delete/{id}', 'CommentController@delete');
        Route::get('restore/{id}', 'CommentController@restore');
        Route::get('destroy/{id}', 'CommentController@destroy');
        Route::post('{type?}', 'CommentController@bulkAction');
        Route::get('{type?}', 'CommentController@index');
        Route::patch('edit/{comment}', 'CommentController@update');
    });

    Route::prefix('reports')->group(function () {
        Route::get('view/{id}', 'ReportController@view');
        Route::get('acknowledge/{id}', 'ReportController@acknowledge');
        Route::get('unacknowledge/{id}', 'ReportController@unacknowledge');
        Route::get('delete/{id}', 'ReportController@delete');
        Route::post('create', 'ReportController@store');
        Route::post('{type?}', 'ReportController@bulkAction');
        Route::get('{type?}', 'ReportController@index');
    });

    Route::prefix('news')->group(function () {
        Route::get('edit/{id}', 'NewsController@edit');
        Route::patch('edit/{id}', 'NewsController@update');
        Route::get('create/', 'NewsController@create');
        Route::post('create/', 'NewsController@store');
        Route::get('delete/{id}', 'NewsController@delete');
        Route::get('restore/{id}', 'NewsController@restore');
        Route::get('destroy/{id}', 'NewsController@destroy');
        Route::patch('edit/{id}/publish', 'NewsController@publish');
        Route::post('{type?}', 'NewsController@bulkAction');
        Route::get('{type?}', 'NewsController@index');
    });

    Route::prefix('faqs')->group(function () {
        Route::get('edit/{id}', 'FAQController@edit');
        Route::patch('edit/{id}', 'FAQController@update');
        Route::get('create/', 'FAQController@create');
        Route::post('create/', 'FAQController@store');
        Route::get('delete/{id}', 'FAQController@delete');
        Route::get('{type?}', 'FAQController@index');
    });

    Route::prefix('faqs-categories')->group(function () {
        Route::get('create', 'FAQCategoryController@create');
        Route::post('create', 'FAQCategoryController@store');
        Route::get('edit/{id}', 'FAQCategoryController@edit');
        Route::patch('edit/{id}', 'FAQCategoryController@update');
        Route::get('delete/{id}', 'FAQCategoryController@destroy');
        Route::get('{type?}', 'FAQCategoryController@index');
    });

    Route::prefix('genres')->group(function () {
        Route::get('create', 'GenreController@create');
        Route::post('create', 'GenreController@store');
        Route::get('edit/{id}', 'GenreController@edit');
        Route::patch('edit/{id}', 'GenreController@update');
        Route::get('delete/{id}', 'GenreController@delete');
        Route::get('restore/{id}', 'GenreController@restore');
        Route::get('destroy/{id}', 'GenreController@destroy');
        Route::post('{type?}', 'GenreController@bulkAction');
        Route::get('{type?}', 'GenreController@index');
    });

    Route::prefix('releases')->group(function () {
        Route::get('edit/{id}', 'ReleaseController@edit');
        Route::patch('edit/{id}', 'ReleaseController@update');
        Route::get('delete/{id}', 'ReleaseController@delete');
        Route::get('restore/{id}', 'ReleaseController@restore');
        Route::get('destroy/{id}', 'ReleaseController@destroy');
        Route::get('approve/{id}', 'ReleaseController@approve');
        Route::get('take-offline/{id}', 'ReleaseController@takeOffline');
        Route::get('make-live/{id}', 'ReleaseController@makeLive');
        Route::get('featured-date/{id}/approve', 'ReleaseController@featuredDateApprove');
        Route::get('featured-date/{id}/decline', 'ReleaseController@featuredDateDecline');
        Route::post('{type?}', 'ReleaseController@bulkAction');
        Route::get('{type?}', 'ReleaseController@index');
    });

    Route::prefix('tracks')->group(function () {
        Route::get('release/{id}', 'TrackController@show');
        Route::get('destroy/{id}', 'TrackController@destroy');
        Route::get('freeze/{id}', 'TrackController@freeze');
        Route::get('approve/{id}', 'TrackController@approve');
        Route::get('edit/{id}', 'TrackController@edit');
        Route::patch('edit/{id}', 'TrackController@update');
        Route::get('{type?}', 'TrackController@index');
    });

    Route::prefix('users')->group(function () {
        Route::get('edit/{id}', 'UserController@edit');
        Route::patch('edit/{id}', 'UserController@update');
        Route::post('edit/{id}', 'UserController@approve');
        Route::get('create/', 'UserController@create');
        Route::post('create/', 'UserController@store');
        Route::get('freeze/{id}', 'UserController@freeze');
        Route::get('activate/{id}', 'UserController@activate');
        Route::get('delete/{id}', 'UserController@delete');
        Route::get('restore/{id}', 'UserController@restore');
        Route::get('destroy/{id}', 'UserController@destroy');
        Route::get('ban/{id}', 'UserController@ban');
        Route::get('approve/{id}', 'UserController@approve');
        Route::get('unapprove/{id}', 'UserController@unapprove');
        Route::post('{type?}', 'UserController@bulkAction');
        Route::get('{type?}/{value?}', 'UserController@index');
        
    });

    Route::prefix('roles')->group(function () {
        Route::get('edit/{id}', 'RoleController@edit');
        Route::patch('edit/{id}', 'RoleController@update');
        Route::get('create', 'RoleController@create');
        Route::post('create', 'RoleController@store');
        Route::get('delete/{id}', 'RoleController@destroy');
        Route::post('{type?}', 'RoleController@bulkAction');
        Route::get('', 'RoleController@index');
    });

    Route::prefix('permissions')->group(function () {
        Route::get('edit/{id}', 'PermissionController@edit');
        Route::patch('edit/{id}', 'PermissionController@update');
        Route::get('create', 'PermissionController@create');
        Route::post('create', 'PermissionController@store');
        Route::get('delete/{id}', 'PermissionController@destroy');
        Route::post('{type?}', 'PermissionController@bulkAction');
        Route::get('', 'PermissionController@index');
    });

    Route::prefix('meta')->group(function () {
        Route::get('edit/{id}', 'MetaController@edit');
        Route::patch('edit/{id}', 'MetaController@update');
        Route::get('create/{pageId?}', 'MetaController@create');
        Route::post('create/{pageId?}', 'MetaController@store');
        Route::get('delete/{id}', 'MetaController@destroy');
        Route::get('get/{pageId}', 'MetaController@getPageMetas');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', 'SettingsController@edit');
        Route::patch('/', 'SettingsController@update');
    });

    Route::prefix('plans')->group(function () {
        Route::get('/', 'PlanController@index');
        Route::get('create/', 'PlanController@create');
        Route::post('create/', 'PlanController@store');
        Route::get('edit/{plan}', 'PlanController@edit');
        Route::patch('edit/{plan}', 'PlanController@update');
        Route::get('delete/{plan}', 'PlanController@destroy');
    });
});
