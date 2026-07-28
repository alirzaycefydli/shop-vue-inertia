<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Home');
})->name('home');

Route::get('/products', function () {
    return inertia('Products/Index');
})->name('products.index');

Route::get('/products/{slug}', function (string $slug) {
    return inertia('Products/Show', [
        'slug' => $slug,
    ]);
})->name('products.show');

Route::get('/categories/{category?}', function (?string $category = null) {
    return inertia('Categories/Index', [
        'category' => $category,
    ]);
})->name('categories.index');
