<?php

use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| The project is API-first. Only the landing page, the HTML API reference
| and the post-login landing page are exposed on the web side. The previous
| Eloquent data-dump routes were removed (they leaked the whole database).
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/documentation', [DocumentationController::class, 'index'])->name('documentation');
