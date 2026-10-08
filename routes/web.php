<?php

use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get(config('access.path'), [SessionController::class, 'create'])->name('access.create');
    Route::post(config('access.path'), [SessionController::class, 'store'])
        ->middleware('throttle:access')
        ->name('access.store');
});

Route::middleware('admin')->group(function () {
    require __DIR__.'/admin.php';
});
