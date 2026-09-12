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
