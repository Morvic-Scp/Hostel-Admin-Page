<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'App\Http\Controllers\HostelController@index');
Route::get('/editprice', 'App\Http\Controllers\HostelController@editprice');
Route::get('/history', 'App\Http\Controllers\HostelController@history');
Route::post('/', 'App\Http\Controllers\HostelController@storeindex');
Route::post('/editprice', 'App\Http\Controllers\HostelController@storeeditprice');
Route::post('/', 'App\Http\Controllers\HostelController@storebookroom');
Route::post('/history/update', 'App\Http\Controllers\HostelController@updatelease');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
