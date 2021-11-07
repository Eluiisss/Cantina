<?php


use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CategoriesController;
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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/users', [UserController::class, 'index'])->middleware(['role:administrator|employee'])->name('users.index');
Route::get('/users/delete/{id}', [UserController::class , 'destroy'])->middleware(['role:administrator|employee'])->name('users.destroy');
Route::get('/users/{user}/show', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');


Route::get('/food', [ArticlesController::class, 'index'])->name('articles.index');
Route::get('/food/{article}/show', [ArticlesController::class, 'show'])->name('articles.show');
Route::get('/food/create', [ArticlesController::class, 'create'])->name('articles.create');
Route::post('/food/', [ArticlesController::class, 'store'])->name('articles.store');
Route::get('/food/{article}/edit', [ArticlesController::class, 'edit'])->name('articles.edit');
Route::put('/food/{article}', [ArticlesController::class, 'update'])->name('articles.update');
Route::delete('/food/{id}', [ArticlesController::class, 'destroy'])->name('articles.destroy');

Route::get('/food/trash', [ArticlesController::class, 'index'])->name('articles.trashed');
Route::patch('/food/{article}/trash', [ArticlesController::class, 'trash'])->name('articles.trash');
Route::get('/food/{id}/restore', [ArticlesController::class, 'restore'])->name('articles.restore');

Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}/show', [CategoriesController::class, 'show'])->name('categories.show');
Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
Route::post('/categories/', [CategoriesController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');

require __DIR__.'/auth.php';
