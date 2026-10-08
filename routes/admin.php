<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QuoteRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get(config('access.path').'/'.config('access.board'), [DashboardController::class, 'show'])
    ->name('admin.dashboard');

Route::post(config('access.path').'/logout', [SessionController::class, 'destroy'])
    ->name('admin.logout');

Route::get(config('access.path').'/products', [ProductController::class, 'index'])
    ->name('admin.products.index');

Route::get(config('access.path').'/products/create', [ProductController::class, 'create'])
    ->name('admin.products.create');

Route::post(config('access.path').'/products', [ProductController::class, 'store'])
    ->name('admin.products.store');

Route::get(config('access.path').'/products/{product}/edit', [ProductController::class, 'edit'])
    ->name('admin.products.edit');

Route::put(config('access.path').'/products/{product}', [ProductController::class, 'update'])
    ->name('admin.products.update');

Route::delete(config('access.path').'/products/{product}', [ProductController::class, 'destroy'])
    ->name('admin.products.destroy');

Route::get(config('access.path').'/categories', [CategoryController::class, 'index'])
    ->name('admin.categories.index');

Route::get(config('access.path').'/categories/create', [CategoryController::class, 'create'])
    ->name('admin.categories.create');

Route::post(config('access.path').'/categories', [CategoryController::class, 'store'])
    ->name('admin.categories.store');

Route::get(config('access.path').'/categories/{category}/edit', [CategoryController::class, 'edit'])
    ->name('admin.categories.edit');

Route::put(config('access.path').'/categories/{category}', [CategoryController::class, 'update'])
    ->name('admin.categories.update');

Route::delete(config('access.path').'/categories/{category}', [CategoryController::class, 'destroy'])
    ->name('admin.categories.destroy');

Route::get(config('access.path').'/quotes', [QuoteRequestController::class, 'index'])
    ->name('admin.quotes.index');

Route::get(config('access.path').'/quotes/{quote}', [QuoteRequestController::class, 'show'])
    ->name('admin.quotes.show');

Route::put(config('access.path').'/quotes/{quote}/status', [QuoteRequestController::class, 'updateStatus'])
    ->name('admin.quotes.update-status');

Route::delete(config('access.path').'/quotes/{quote}', [QuoteRequestController::class, 'destroy'])
    ->name('admin.quotes.destroy');

Route::get(config('access.path').'/messages', [ContactMessageController::class, 'index'])
    ->name('admin.messages.index');

Route::get(config('access.path').'/messages/{message}', [ContactMessageController::class, 'show'])
    ->name('admin.messages.show');

Route::patch(config('access.path').'/messages/{message}/read', [ContactMessageController::class, 'toggleRead'])
    ->name('admin.messages.toggle-read');

Route::put(config('access.path').'/messages/{message}', [ContactMessageController::class, 'update'])
    ->name('admin.messages.update');

Route::delete(config('access.path').'/messages/{message}', [ContactMessageController::class, 'destroy'])
    ->name('admin.messages.destroy');
