<?php

use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\User\UserController;
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

Route::middleware(['auth.api'])->group(
    function () {
    }
);
Route::post('login', [UserController::class, 'login']);
Route::get('payment/makePayment/{system}', [PaymentController::class, 'createPayment']);
Route::post('payment/confirm/{system}', [PaymentController::class, 'confirmPayment']);
Route::apiResource('books', BookController::class);
Route::apiResource('categories', CategoryController::class);

Route::get('booksIt', [BookController::class, 'indexIterator']);
Route::get('booksMo', [BookController::class, 'indexModel']);
Route::get('booksItCache', [BookController::class, 'indexIteratorCache']);
