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
Route::get('/', 'HomeController@index')->name('home');
// Route::get('/vkauth', 'HomeController@vkauth');
Route::get('/#/error/{message}', 'HomeController@index')->name('error');

Route::get('/testpush', function () {
  return view('push');
});


Route::get('/{user}/{token}/youtube', 'YoutubeController@playVideo')->middleware('TokenPushMessage');


Route::namespace('Oauth')->group(function () {
    # YouTube
    Route::get('/oauth2callback', 'YouTubeController@redirect');

    # Socialite
    Route::prefix('oauth')->group(function () {
        Route::get('/{service}', 'SocialiteController@redirectToProvider');
        Route::get('/{service}/rollback', 'SocialiteController@handleProviderCallback');
    });

    # Twitch
    Route::prefix('twitch')->group(function () {
        Route::get('/login', 'TwitchController@redirect');
        Route::get('/login/rollback', 'TwitchController@rollback');
    });

});

