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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

 Route::get('/home', 'BreathingController@breathing')->name('home');
//
 Route::get('/welcome', 'HrvController@hrv')->name('home');

//Route::get('/chart','BreathingController@chart');

// Route::get('breathing', 'BreathingController@breathing')->name('breathing');
//
// Route::get('hrv', 'HrvController@hrv')->name('hrv');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
