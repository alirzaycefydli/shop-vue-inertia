<?php

declare(strict_types=1);

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::middleware('auth')->group(function () {
    Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlists.index');
    Route::post('/wishlists/{product:slug}', [WishlistController::class, 'store'])->name('wishlists.store');
    Route::delete('/wishlists/{product:slug}', [WishlistController::class, 'destroy'])->name('wishlists.destroy');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/items/{product:slug}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/items/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/items/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
