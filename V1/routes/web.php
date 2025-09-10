<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartsController;

Route::get('/', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('can:edit');
    Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy')->middleware('can:delete');
    Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit')->middleware('can:edit');

    Route::patch('/products/{id}', [ProductsController::class, 'patch'])->name('products.patch')->middleware('can:edit');
    Route::put('/products/{id}', [ProductsController::class, 'put'])->name('products.put')->middleware('can:edit');
    Route::post( '/products/create', [ProductsController::class, 'store'])->name('products.store')->middleware('can:edit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('showSignup');
});


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

Route::get('/cart', function () {
    return view('cart');
});
