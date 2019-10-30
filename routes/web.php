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

// Provide controller methods with object instead of ID
Route::model('hosts', 'Host');

Route::bind('hosts', function($value, $route) {
    return App\Host::whereId($value)->first();
});

//Model routes
Route::resource('hosts', 'HostController');