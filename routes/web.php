<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('bookmeeting', 'bookMeetingController');

Route::resource('user', 'userController');

Route::get('search_user', 'BookMeetingController@search_user')->name('search_user');

Route::GET('ajax_getMeetingRoom', 'BookMeetingController@ajax_getMeetingRoom')->name('ajax_getMeetingRoom');


