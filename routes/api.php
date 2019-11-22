<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/test', 'HomeController@test');

Route::post('/paykeeper/alert', 'PaykeeperController@paykeeperAlert');
Route::get('/paykeeper/{id}', 'PaykeeperController@fethPayment');

Route::get('/mainsettings', 'SettingsController@mainSettings');

Route::middleware('jwt.verify')->group(function () {
    Route::get('/mystreamlink', 'UserController@myStreamLink');
    Route::get('/recentoperations', 'UserController@recentoperations');
    Route::get('/user', 'UserController@profile');
    Route::put('/user', 'UserController@update');
    Route::delete('/user/service/{service}', 'UserController@serviceDisconnect');
    // Route::get('/mycards', 'UserController@mycards');
    Route::get('/subscribers', 'UserController@subscribers');
    Route::get('/subscribers/statistic', 'StatisticController@fetchSubscribers');
    Route::get('/fetchlinks', 'UserController@fetchlinks');
    Route::get('/transactions', 'TransactionController@transactions');
    Route::get('/transactions/statistic', 'TransactionController@transactionsStatistic');
    Route::get('/statistic/donate', 'StatisticController@fetchDonate');
    Route::post('/image/upload', 'SettingsController@imageUpload');
    Route::post('/video/upload', 'SettingsController@videoUpload');
    Route::post('/donate/settings/{user}', 'SettingsController@donateSettingsSave');
    Route::put('/donate/settings/{user}', 'SettingsController@donateSettingsReset');

    Route::prefix('payments')->group(function() {
        Route::post('/add', 'PaymentMethodsController@add');
        Route::delete('/{paymentMethod}', 'PaymentMethodsController@remove');
        Route::get('/list', 'PaymentMethodsController@list');
        Route::post('/{method}', 'PaymentMethodsController@update');
    });

    Route::prefix('twitch')->group(function () {
        Route::get('/followsList', 'TwitchController@followsList');
        Route::get('/test', 'TwitchController@test');
        Route::get('/channels/{channel}', 'TwitchController@channelInfoById');
    });

    Route::prefix('mailstone')->group(function () {
        Route::get('/list', 'MailstonesController@list');
        Route::delete('/{milestone}', 'MailstonesController@remove');
        Route::post('/add', 'MailstonesController@add');
        Route::get('/badges', 'MailstonesController@badges');
        Route::get('/{user}/badge', 'MailstonesController@badge');
        Route::get('/{user}/sound', 'MailstonesController@music');
        Route::get('/animations', 'MailstonesController@animations');
        Route::get('/closest', 'MailstonesController@closets');
        Route::post('/badge/upload', 'MailstonesController@imageUpload');
        Route::post('/sound/upload', 'MailstonesController@soundUpload');
        Route::post('/badge/add', 'BadgesController@add');
    });

    Route::prefix('premium')->group(function () {
        Route::get('/{user}/milestones', 'UserController@milestones');
        Route::get('/{user}/checksubscribe', 'UserController@checkSubscriber');
        Route::post('/{user}/premiumsubscribe', 'UserController@premiumSubscribed');
    });
    Route::get('/{user}/mydonat', 'UserController@mydonat');
    Route::get('/mynotification', 'UserController@mynotification');
    Route::post('/mynotification', 'UserController@mynotificationAdded');
    Route::put('/mynotification/{id}', 'UserController@notificationDelete');
});


Route::prefix('widget')->group(function () {
    Route::middleware('jwt.verify')->group(function () {
        Route::post('/add', 'WidgetController@add');
        Route::post('/', 'WidgetController@addV2');
        Route::get('/list', 'WidgetController@list');
        Route::get('/list-v2', 'WidgetController@listV2');
        Route::get('/options', 'WidgetCategoryController@index');
        Route::delete('/{widget}', 'WidgetController@delete');
        Route::get('/activate/{widget}', 'WidgetController@activate');
        Route::put('/{widget}', 'WidgetController@editWidget');
        Route::put('/{widget}/v2', 'WidgetController@editWidgetV2');
    });
    Route::get('/{widgetCategory}', 'WidgetCategoryController@show')->name('widget.view');
    // Route::get('/{widget}', 'WidgetController@widget')->name('widget.view');
});


Route::prefix('alerts')->group(function () {
    Route::middleware('jwt.verify')->group(function () {
        Route::get('/', 'AlertController@index');
        Route::post('/', 'AlertController@create');
        Route::post('/preview/{type}', 'AlertController@preview');
        Route::delete('/{alert}', 'AlertController@destroy');
        Route::put('/{alert}', 'AlertController@update');

        Route::post('/file', 'AlertController@image');
    });
});


Route::prefix('push')->middleware('TokenPushMessage')->group(function () {
    Route::post('/video/{user}/{push_id}/{token}', 'PushController@uploadvideo');
    Route::delete('/video/{user}/{push_id}/{token}', 'PushController@uploadvideo');
    Route::post('/image/{user}/{push_id}/{token}', 'PushController@uploadimage');
    Route::delete('/image/{user}/{push_id}/{token}', 'PushController@uploadimage');
    Route::post('/music/{user}/{token}', 'PushController@uploadmusic');
    Route::delete('/music/{user}/{token}', 'PushController@uploadmusic');
    Route::get('/server/{user}/{type}/{token}', 'PushController@server');
    Route::get('/client/{user}/{push_id}/{token}', 'PushController@client');
    Route::get('/client/{user}/{type}/{token}/view', 'PushController@clientView');
    Route::get('/settings/{user}/{type}/{token}', 'PushController@fetch');
    Route::post('/settings/{user}/{push_id}/{token}', 'PushController@save');
    Route::put('/settings/{user}/{push_id}/{token}', 'PushController@reset');

    Route::put('/test_notification/{user}/{push_id}/{token}', 'PushController@testNotification');
});

Route::prefix('insidestreaming/{user}/{token}')->middleware('TokenPushMessage')->group(function () {

    Route::post('/lastmessage', 'InsideStreamingController@lastMessage');
    Route::post('/mostexpensive', 'InsideStreamingController@mostExpensive');
    Route::post('/largestdonater', 'InsideStreamingController@largestDonater');
    Route::post('/lastdonater', 'InsideStreamingController@lastDonater');
    Route::post('/lastsubscriber', 'InsideStreamingController@lastSubscriber');
    Route::post('/numbersubscribers', 'InsideStreamingController@numberSubscribers');
    Route::post('/amountcollected', 'InsideStreamingController@amountCollected');
});
Route::post('/donate', 'TransactionController@donate');
Route::get('/donate', 'TransactionController@donateInfo');
Route::post('/donate/settings/', 'SettingsController@donateSettings');
Route::get('/user/donationformdata/', 'UserController@getDonationFormData');
Route::get('/user/info/{user}', 'UserController@userInfo');
Route::get('/user/streams/{user}', 'TwitchController@getUserStreams');

Route::get('/fonts', 'HomeController@fonts');
Route::get('/icons', 'HomeController@icons');


Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::post('/login', 'AuthController@authenticate');

    Route::group(['middleware' => ['jwt.verify', '2fa']], function() {
        Route::get('/transaction/all', 'TransactionController@list');
        Route::get('/dashboard', 'DashboardController@index');
        Route::get('/users/list', 'UserController@list');
        Route::post('/user/update', 'UserController@update');
        Route::post('/user/status/update', 'UserController@updateStatus');
        Route::get('/settings/donate', 'SettingsController@fetchDonate');
        Route::post('/settings/donate', 'SettingsController@saveDonate');

        Route::get('/settings/subscriber', 'SettingsController@fetchSubscriber');
        Route::post('/settings/subscriber', 'SettingsController@saveSubscriber');

        Route::get('/statistic/donate', 'StatisticController@fetchDonate');
    });

    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('/user', 'UserController@info');
        Route::get('/login2fa', 'AuthController@login2faQR');
        Route::post('/login2fa', 'AuthController@login2fa');
    });
});
// Route::post('/login', 'AuthController@login');
Route::apiResource('{user}/{token}/youtube', 'YoutubeController')
    ->middleware('TokenPushMessage');

Route::any('/twitch/webhook', 'TwitchController@webhook');
