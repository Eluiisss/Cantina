<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\UserController;
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
    return view('welcome');
});

Route::get('/food', [ArticlesController::class, 'index']);

Route::get('/users', [UserController::class, 'index']);

Route::get('/users/delete/{id}', [UserController::class , 'destroy'])->name('users.destroy');


