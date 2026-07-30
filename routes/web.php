<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::Class, 'index'])->name('home');

Route::get('/products', function () {
    return inertia('Products/Index');
})->name('products.index');

Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/categories/{category?}', function (?string $category = null) {
    return inertia('Categories/Index', [
        'category' => $category,
    ]);
})->name('categories.index');
