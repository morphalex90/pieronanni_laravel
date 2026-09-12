<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Inertia\ExceptionResponse;
use Inertia\Inertia;

final class AppServiceProvider extends ServiceProvider
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
        FilamentColor::register([
            'royal' => Color::generateV3Palette('#ff1493'),
        ]);

        $this->configureDefaults();
        $this->configureRateLimiting();
        $this->configureErrorPages();
    }

    /**
     * Render the Inertia error page for the status codes worth a branded page.
     * Skipped while debug mode is on so the Ignition exception page stays visible.
     */
    protected function configureErrorPages(): void
    {
        Inertia::handleExceptionsUsing(function (ExceptionResponse $response): ExceptionResponse {
            if (app()->hasDebugModeEnabled()) {
                return $response;
            }

            if ($response->request->expectsJson() || $response->request->is('api/*', 'admin/*')) {
                return $response;
            }

            if (! in_array($response->statusCode(), [403, 404, 419, 429, 500, 503], true)) {
                return $response;
            }

            return $response
                ->render('error', ['status' => $response->statusCode()])
                ->withSharedData();
        });
    }

    /**
     * Register the named rate limiters used by the public, unauthenticated
     * routes. Both endpoints are expensive: one sends mail, the other spawns a
     * headless browser and writes a row per request.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('contact', fn (Request $request): Limit => Limit::perMinute(5)->by($request->ip()));

        RateLimiter::for('pdf', fn (Request $request): Limit => Limit::perMinute(20)->by($request->ip()));
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
