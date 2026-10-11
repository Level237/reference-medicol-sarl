<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::view('/a-propos', 'about')->name('about');

Route::get('/produits/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/panier', [CartController::class, 'store'])->name('cart.store');
Route::get('/panier/compteur', [CartController::class, 'count'])->name('cart.count');

Route::middleware('guest')->group(function () {
    Route::get(config('access.path'), [SessionController::class, 'create'])->name('access.create');
    Route::post(config('access.path'), [SessionController::class, 'store'])
        ->middleware('throttle:access')
        ->name('access.store');
});

Route::middleware('admin')->group(function () {
    require __DIR__.'/admin.php';
});
