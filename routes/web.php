<?php


use App\Http\Controllers\{ArticlesController, CategoriesController, PaypalController, OrdersController, ShopController, UserController, CartController};
use App\Http\Livewire\OrderUserHistory;
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

Route::post('/cart/', [CartController::class, 'store'])->name('cart.store');
Route::get('/cart', [CartController::class, 'cart'])->name('shop.cart');

Route::get('/addToCart/{id}', [ArticlesController::class, 'addToCart'])->name('article.addToCart');

Route::get('/checkout',[ShopController::class, 'checkout'])->middleware(['role:user|administrator'])->name('shop.checkout');
Route::post('/payment',[ShopController::class, 'paymentAction'])->middleware(['role:user|administrator'])->name('shop.payment');

Route::get('/orders', [OrdersController::class, 'index'])->middleware(['role:employee|administrator'])->name('orders.index');
Route::get('/manageOrders', [OrdersController::class, 'manageOrders'])->middleware(['role:employee|administrator'])->name('orders.manage');
Route::get('/orders/{order}/show', [OrdersController::class, 'show'])->name('orders.show');
Route::get('/orders/create', [OrdersController::class, 'create'])->name('orders.create');
Route::post('/orders/', [OrdersController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}/edit', [OrdersController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{order}', [OrdersController::class, 'update'])->name('orders.update');
Route::delete('/orders/{id}', [OrdersController::class, 'destroy'])->name('orders.destroy');
Route::get('/orders/createNotPayed', [OrdersController::class, 'createOrderNotPayed'])->name('orders.notPayed');
Route::get('/orders/createPayed', [OrdersController::class, 'createOrderNotPayed'])->name('orders.Payed');

Route::get('/pedidos', OrderUserHistory::class)->middleware(['role:user|administrator'])->name('orders.history');

Route::get('/food', [ArticlesController::class, 'index'])->middleware(['role:employee|administrator'])->name('articles.index');
Route::get('/food/{article}/show', [ArticlesController::class, 'show'])->name('articles.show');
Route::get('/food/create', [ArticlesController::class, 'create'])->middleware(['role:employee|administrator'])->name('articles.create');
Route::post('/food/', [ArticlesController::class, 'store'])->middleware(['role:employee|administrator'])->name('articles.store');
Route::get('/food/{article}/edit', [ArticlesController::class, 'edit'])->middleware(['role:employee|administrator'])->name('articles.edit');
Route::put('/food/{article}', [ArticlesController::class, 'update'])->middleware(['role:employee|administrator'])->name('articles.update');
Route::delete('/food/{id}', [ArticlesController::class, 'destroy'])->middleware(['role:employee|administrator'])->name('articles.destroy');

Route::get('/food/trash', [ArticlesController::class, 'index'])->middleware(['role:employee|administrator'])->name('articles.trashed');
Route::patch('/food/{article}/trash', [ArticlesController::class, 'trash'])->middleware(['role:employee|administrator'])->name('articles.trash');
Route::get('/food/{id}/restore', [ArticlesController::class, 'restore'])->middleware(['role:employee|administrator'])->name('articles.restore');

Route::get('/categories', [CategoriesController::class, 'index'])->middleware(['role:employee|administrator'])->name('categories.index');
Route::get('/categories/{category}/show', [CategoriesController::class, 'show'])->middleware(['role:employee|administrator'])->name('categories.show');
Route::get('/categories/create', [CategoriesController::class, 'create'])->middleware(['role:employee|administrator'])->name('categories.create');
Route::post('/categories/', [CategoriesController::class, 'store'])->middleware(['role:employee|administrator'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoriesController::class, 'edit'])->middleware(['role:employee|administrator'])->name('categories.edit');
Route::put('/categories/{category}', [CategoriesController::class, 'update'])->middleware(['role:employee|administrator'])->name('categories.update');
Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->middleware(['role:employee|administrator'])->name('categories.destroy');

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
    Route::get('/users/createEmployee', [UserController::class, 'createEmployee'])->middleware(['role:administrator'])->name('users.createEmployee');
    Route::post('/users/', [UserController::class, 'storeEmployee'])->name('users.storeEmployee');
});

Route::post('paypal/order/create', [PaypalController::class , 'create']);
Route::post('paypal/order/capture', [PaypalController::class , 'capture']);

require __DIR__.'/auth.php';
