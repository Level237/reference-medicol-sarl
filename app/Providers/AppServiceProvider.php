<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
