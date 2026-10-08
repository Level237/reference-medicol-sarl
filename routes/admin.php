<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get(config('access.path').'/'.config('access.board'), [DashboardController::class, 'show'])
    ->name('admin.dashboard');

Route::post(config('access.path').'/logout', [SessionController::class, 'destroy'])
    ->name('admin.logout');
