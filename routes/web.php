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
    return redirect('images');
});
Route::get('admin', function () {
    return redirect('home');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
Route::match(['get', 'post'], 'images/search', 'ImageController@search');
Route::resource('images', 'ImageController')->except('index', 'show')->middleware('auth');
Route::resource('images', 'ImageController')->only('index', 'show');
Route::resource('admin/categories', 'CategoryController');
Route::get('admin/users', 'UserController@index')->middleware('auth');
Route::delete('admin/users/{id}', 'UserController@block')->middleware('auth');
Route::post('admin/users/{id}/restore', 'UserController@restore')->middleware('auth');

