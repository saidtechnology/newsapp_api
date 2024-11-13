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

Route::get('/users', function () {
    return \App\User::all();
});

Route::get('/categories', function () {
    return \App\Category::all();
});

Route::get('/posts', function () {
    return \App\Post::all();
});

Route::get('/comments', function () {
    return \App\Comment::all();
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/documentation', 'DocumentationController@index')->name('documentation');
