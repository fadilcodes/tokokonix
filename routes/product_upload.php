<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Dedicated routes for product upload page
Route::middleware('auth')->group(function () {
    Route::get('/product/upload', [ProductController::class, 'create'])->name('product.upload');
    Route::post('/product/upload', [ProductController::class, 'store'])->name('product.upload.store');
});

