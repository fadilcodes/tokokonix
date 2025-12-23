<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HistoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pesan/{id}', [PesanController::class, 'index'])->name('pesan');
    Route::post('pesan/{id}', [PesanController::class, 'pesan']);
    Route::get('checkout/{id}', [PesanController::class, 'checkout']);
    Route::delete('checkout/hapus/{id}', [PesanController::class, 'delete']);
    Route::get('konfirmasi-check-out/kurang/{id}', [PesanController::class, 'konfirmasi_kurang']);
    Route::get('konfirmasi-check-out/tambah/{id}', [PesanController::class, 'konfirmasi_tambah']);
    Route::get('payment/finish', [PesanController::class, 'payment_finish']);
    Route::get('history', [HistoryController::class, 'index']);
    Route::get('history/{id}', [HistoryController::class, 'detail']);
});


require __DIR__.'/auth.php';
