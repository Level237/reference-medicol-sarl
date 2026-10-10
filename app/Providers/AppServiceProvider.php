<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\QuoteRequest;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\View as RenderedView;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.header', function (RenderedView $view): void {
            if (! Schema::hasTable('categories')) {
                $view->with('searchCategories', collect());

                return;
            }

            $view->with('searchCategories', Category::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get());
        });

        View::composer(['admin.layout', 'admin.dashboard'], function (RenderedView $view): void {
            $admin = auth()->user();

            if ($admin === null) {
                return;
            }

            $view->with([
                'admin' => $admin,
                'initial' => mb_strtoupper(mb_substr((string) $admin->name, 0, 1)),
                'stats' => [
                    'products_count' => Product::query()->count(),
                    'products_published' => Product::query()->where('is_published', true)->count(),
                    'categories_count' => Category::query()->count(),
                    'quotes_count' => QuoteRequest::query()->where('status', QuoteRequest::STATUS_PENDING)->count(),
                    'messages_count' => ContactMessage::query()->where('is_read', false)->count(),
                ],
            ]);
        });

        RateLimiter::for('access', function (Request $request) {
            $email = Str::transliterate(Str::lower((string) $request->input('email')));

            return Limit::perMinute((int) config('access.rate_limit.max_attempts'))
                ->by($email.'|'.$request->ip())
                ->response(function () {
                    return redirect()->route('access.create')->withErrors([
                        'email' => 'Trop de tentatives. Réessayez dans une minute.',
                    ]);
                });
        });
    }
}
