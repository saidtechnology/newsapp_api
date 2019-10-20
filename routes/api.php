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

Route::get('users', function () {
    $users = \App\User::paginate();
    return new \App\Http\Resources\UsersResource($users);

});

Route::get('categories', function () {
    $users = \App\Category::paginate();
    return new \App\Http\Resources\CategoriesResouce($users);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
