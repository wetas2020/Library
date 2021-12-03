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

Route::post('/books', [App\Http\Controllers\BooksController::class, 'store']);
Route::patch('/books/{book}', [App\Http\Controllers\BooksController::class, 'update']);
Route::delete('/books/{book}', [App\Http\Controllers\BooksController::class, 'destroy']);


Route::post('/authors', [App\Http\Controllers\AuthorsController::class, 'store']);
Route::get('/authors/create', [App\Http\Controllers\AuthorsController::class, 'create']);

Route::post('/checkout/{book}', [App\Http\Controllers\CheckoutBookController::class, 'store']);

Route::post('/checkin/{book}', [App\Http\Controllers\CheckinBookController::class, 'store']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
