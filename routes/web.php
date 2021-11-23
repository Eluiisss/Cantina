<?php


use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
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

Route::get('/', [ShopController::class, 'index'])->name('home');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{article}/show', [ShopController::class, 'show'])->name('shop.show');

Route::get('/addToCart/{id}', [ArticlesController::class, 'addToCart'])->name('article.addToCart');
Route::get('/cart', [ArticlesController::class, 'cart'])->name('article.cart');

Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}/show', [OrdersController::class, 'show'])->name('orders.show');
Route::get('/orders/create', [OrdersController::class, 'create'])->name('orders.create');
Route::post('/orders/', [OrdersController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}/edit', [OrdersController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{order}', [OrdersController::class, 'update'])->name('orders.update');
Route::delete('/orders/{id}', [OrdersController::class, 'destroy'])->name('orders.destroy');

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

Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->middleware(['role:administrator|employee'])->name('users.index');
    Route::delete('/users/delete/{id}', [UserController::class , 'destroy'])->middleware(['role:administrator|employee'])->name('users.destroy');
    Route::get('/users/papelera', [UserController::class , 'index'])->middleware(['role:administrator|employee'])->name('users.trashed');
    Route::get('/users/{user}/show', [UserController::class, 'show'])->middleware(['role:administrator|employee'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware(['role:administrator|employee'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware(['role:administrator|employee'])->name('users.update');
    Route::get('/users/bann/{id}', [UserController::class, 'bann'])->middleware(['role:administrator|employee'])->name('users.bann');
    Route::put('/users/{id}/papelera', [UserController::class, 'restore'])->middleware(['role:administrator|employee'])->name('users.restore');
    Route::patch('/users/{user}/papelera', [UserController::class, 'trash'])->middleware(['role:administrator|employee'])->name('users.trash');
});

require __DIR__.'/auth.php';
