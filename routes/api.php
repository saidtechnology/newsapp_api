<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SummaryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All routes here are automatically prefixed with /api by bootstrap/app.php
| and receive the "api" middleware group (throttling + bindings).
|
*/

// Authors
Route::get('authors', [UserController::class, 'index']);
Route::get('authors/{id}', [UserController::class, 'show']);
Route::get('posts/author/{id}', [UserController::class, 'posts']);
Route::get('comments/author/{id}', [UserController::class, 'comments']);

// Categories
Route::get('categories', [CategoryController::class, 'index']);
Route::get('posts/categories/{id}', [CategoryController::class, 'posts']);

// Posts
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{id}', [PostController::class, 'show']);
Route::get('posts/{id}/summary', [SummaryController::class, 'show'])->middleware('throttle:10,1');
Route::get('comments/posts/{id}', [PostController::class, 'comments']);

// Authentication
Route::post('register', [UserController::class, 'store']);
Route::post('token', [UserController::class, 'getToken']);

// Protected routes (Bearer api_token)
Route::middleware('auth:api')->group(function () {
    Route::post('update-user/{id}', [UserController::class, 'update']);

    Route::post('posts', [PostController::class, 'store']);
    Route::post('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);

    Route::post('comments/posts/{id}', [CommentController::class, 'store']);
});
