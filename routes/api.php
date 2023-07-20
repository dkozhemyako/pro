<?php

use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Category\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('books', BookController::class);
Route::apiResource('categories', CategoryController::class);


