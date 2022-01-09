<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('api', function (Request $request) {
//     Route::get('/register', 'PassportController@register');
// });


Route::middleware('localization')->group(function () {
    Route::post('login', 'Api\ClientController@login');
    Route::post('register', 'Api\ClientController@register');
    Route::get('center', 'Api\AppController@center');
    Route::get('terms_and_conditions', 'Api\AppController@TermsAndConditions');
    Route::post('contact_email', 'Api\AppController@contactMail');
    Route::get('categories', 'Api\CategoryController@index');
    Route::get('category/{category_id}/{country_id}/trips', 'Api\CategoryController@categoryTrips');
    Route::get('trip/countries', 'Api\TripController@countries');
    Route::get('trip/{id}/show', 'Api\TripController@show');
    Route::get('countries', 'Api\AppController@countries');
    Route::get('sliders', 'Api\AppController@sliders');
    Route::get('media', 'Api\MediaController@index');
    Route::post('media/views/update', 'Api\MediaController@updateViews');
    Route::get('banks', 'Api\BankController@index');
    Route::get('search/{key}', 'Api\AppController@search');
    Route::post('language/update', 'Api\AppController@changeLanguage');

    Route::middleware('auth:api')->group(function () {
        Route::get('profile', 'Api\ClientController@profile');
        Route::post('profile/update', 'Api\ClientController@UpdateProfile');
        Route::post('profile/update/image', 'Api\ClientController@updateProfileImage');
        Route::post('profile/update_password', 'Api\ClientController@updatePassword');
        Route::post('logout', 'Api\ClientController@logout');
        Route::post('special_trip', 'Api\TripController@specialTrip');
        route::get('client/special_trip/reservation/current', 'Api\TripController@specialTripClientCurrentReservations');
        route::get('client/special_trip/reservation/finished', 'Api\TripController@specialTripClientFinishedReservations');
        route::post('trip/reserve', 'Api\TripController@reserveTrip');
        route::get('client/trip/reservation/current', 'Api\TripController@clientCurrentReservations');
        route::get('client/trip/reservation/finished', 'Api\TripController@clientFinishedReservations');
        Route::get('notifications', 'Api\NotificationController@index');
        Route::post('notification/delete', 'Api\NotificationController@delete');
    });
});
