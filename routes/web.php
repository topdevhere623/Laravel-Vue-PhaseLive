<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Mail\TestAmazonSes;
use Illuminate\Support\Facades\Mail;

Route::post('/password/reset', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::post('/password/reset', 'Auth\ForgotPasswordController@index');
Route::post('/password/change', 'Auth\ForgotPasswordController@reset')->name('password.reset');

Route::post('/marketplace/webhook', 'WebhookController@handleWebhook');

Route::get('/login', function () {
    $user = Auth::check()
        ? Auth::user()->setAppends([
            'all_permissions',
            'account_type',
            'avatar',
            'plays',
            'banner',
            'tracks_count_this_month',
        ])
        : 'null';

    return view('vue', compact('user'));
})->name('login');

Route::get('/mail', function () {
    $user = \App\User::find(2);

    return new \App\Mail\NewAccount($user);
});

route::get('testses', function () {
    Mail::to(['rory@wearethunderbolt.com', 'henry@wearethunderbolt.com'])->send(new TestAmazonSes('It works!'));
});

Route::get('/{any?}', function () {
    app('debugbar')->disable();
    $user = Auth::check()
        ? Auth::user()->setAppends([
            'all_permissions',
            'account_type',
            'avatar',
            'plays',
            'banner',
            'tracks_count_this_month',
        ])
        : 'null';
    return view('vue', compact('user'));
})->where('any', '.*');
