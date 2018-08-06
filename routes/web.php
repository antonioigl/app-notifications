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

use Yajra\DataTables\DataTables;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/messages', 'MessageController@store')->name('messages.store');
    Route::get('/messages', 'MessageController@index')->name('messages.index');
    Route::put('/messages', 'MessageController@update')->name('messages.update');
    Route::get('/messages/{message}/show', 'MessageController@show')->name('messages.show');
});