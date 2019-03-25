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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login','API\PassportController@login')->name('user.login');
Route::post('register', 'API\PassportController@register')->name('user.register');

Route::post('resetPassword', 'API\PassportController@resetPassword')->name('user.resetPassword');



Route::get('breathing', 'BreathingController@breathing')->name('user.breathing');
Route::post('storeBreathing', 'BreathingController@store')->name('user.storeBreathing');

Route::get('hrv', 'HrvController@hrv')->name('user.hrv');
Route::post('storeHrv', 'HrvController@store')->name('user.storeHrv');




Route::group(['middleware' => 'auth:api'], function(){
Route::get('user', 'API\PassportController@user')->name('user.user');
Route::get('logout', 'API\PassportController@logout')->name('user.logout');
Route::post('changePassword', 'API\PassportController@changePassword')->name('user.changePassword');
});
