<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TriviaController;
use App\Http\Controllers\ResultController;
use App\Http\Middleware\HasTriviaEnded;
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

Route::get('/', [HomeController::class, 'index']);
Route::get('/trivia', [TriviaController::class, 'index']);
Route::post('/trivia', [TriviaController::class, 'save']);
Route::get('/results', [ResultController::class, 'index'])->middleware(HasTriviaEnded::class);
