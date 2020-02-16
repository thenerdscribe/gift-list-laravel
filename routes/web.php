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

Route::get('/gift', 'GiftController@create')->name('gift-create-form');
Route::post('/gift/create', 'GiftController@store')->name('gift-create');
Route::get('/gift/search/', 'GiftController@search');
Route::get('/gift/claim/{giftId}', 'GiftController@claimConfirm');
Route::patch('/gift/unclaim/{giftId}', 'GiftController@unclaim');
Route::get('/claim/{giftId}', 'GiftController@claim');

Route::get('/user/search', 'UserController@search');
Route::get('/user/search/results', 'UserController@results');
Route::get('/user/{userId}', 'GiftController@index');

