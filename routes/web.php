<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\HomeController;
use App\Http\Controllers\Users\ProductsController;
use App\Http\Controllers\Users\SalesController;
use App\Http\Controllers\Reference\CategoryController;
use App\Http\Controllers\Reference\BrandController;
use App\Http\Controllers\Reference\UnitOfMeasureController;
use App\Http\Controllers\Reference\CustomerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', HomeController::class);

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::middleware('auth.session')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Users\ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Users\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Users\ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/products', [ProductsController::class, '__invoke']);
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');

    Route::get('/sales', [SalesController::class, '__invoke']);
    Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');
    Route::put('/sales/{id}', [SalesController::class, 'update'])->name('sales.update');
    Route::put('/sales/{id}/cancel', [SalesController::class, 'cancel'])->name('sales.cancel');
    Route::delete('/sales/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');

    Route::get('/categories', [CategoryController::class, '__invoke']);
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/brands', [BrandController::class, '__invoke']);
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::put('/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

    Route::get('/uoms', [UnitOfMeasureController::class, '__invoke']);
    Route::post('/uoms', [UnitOfMeasureController::class, 'store'])->name('uoms.store');
    Route::put('/uoms/{id}', [UnitOfMeasureController::class, 'update'])->name('uoms.update');
    Route::delete('/uoms/{id}', [UnitOfMeasureController::class, 'destroy'])->name('uoms.destroy');

    Route::get('/customers', [CustomerController::class, '__invoke']);
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});
