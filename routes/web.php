<?php

use App\Http\Controllers\DocumentationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| The project is API-first. The web side only exposes the landing page and
| an HTML overview of the API. The legacy Eloquent data-dump routes and the
| unused auth scaffolding were removed because they leaked database content
| and required routes that no longer exist.
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/documentation', [DocumentationController::class, 'index'])->name('documentation');
