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


Route::post('login', 'Api\ClientController@login');
Route::post('register', 'Api\ClientController@register');

Route::get('specialties', 'Api\SpecialtyController@index');
Route::get('specialty/{id}', 'Api\SpecialtyController@specialty');

Route::middleware('auth:api')->group(function () {
    Route::get('profile', 'Api\ClientController@profile');
    Route::post('profile/update', 'Api\ClientController@UpdateProfile');
    Route::post('profile/update/image', 'Api\ClientController@updateProfileImage');
    Route::post('profile/update_password', 'Api\ClientController@updatePassword');
    Route::get('appointments/{doctor_id}', 'Api\AppointmentController@doctorAppointments');
    Route::post('day_appointments', 'Api\AppointmentController@dayAppointments');
    route::post('appointment/reserve', 'Api\AppointmentController@reserveAppointment');
    route::post('client/reservation', 'Api\AppointmentController@clientReservations');
    Route::post('messages', 'Api\MessageController@index');
    Route::post('message/create', 'Api\MessageController@create');

    Route::get('about_massara', 'Api\AppController@aboutMassara');
    Route::get('center', 'Api\AppController@center');
    Route::get('terms_and_conditions', 'Api\AppController@TermsAndConditions');
    Route::post('contact_email', 'Api\AppController@contactMail');
    Route::post('logout', 'Api\ClientController@logout');
});