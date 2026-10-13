<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::get('/catalogue', CatalogueController::class)->name('catalogue');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::view('/a-propos', 'about')->name('about');

Route::view('/services', 'services')->name('services');

Route::get('/produits/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier', [CartController::class, 'store'])->name('cart.store');
Route::patch('/panier/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/panier/{productId}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/panier/compteur', [CartController::class, 'count'])->name('cart.count');

Route::get('/devis/demande', [QuoteRequestController::class, 'create'])->name('quotes.create');
Route::post('/devis/demande', [QuoteRequestController::class, 'store'])
    ->middleware('throttle:quotes')
    ->name('quotes.store');
Route::get('/devis/confirmation', [QuoteRequestController::class, 'sent'])->name('quotes.sent');
Route::match(['GET', 'POST'], '/devis/suivi', [QuoteRequestController::class, 'track'])
    ->middleware('throttle:quote-track')
    ->name('quotes.track');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get(config('access.path'), [SessionController::class, 'create'])->name('access.create');
    Route::post(config('access.path'), [SessionController::class, 'store'])
        ->middleware('throttle:access')
        ->name('access.store');
});

Route::middleware('admin')->group(function () {
    require __DIR__.'/admin.php';
});
