<?php

namespace App\Providers;

use App\Models\Click;
use App\Observers\ClickObserver;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;

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
        FilamentColor::register([
            'royal' => Color::hex('#ff1493'),
        ]);

        Click::observe(ClickObserver::class);
    }
}
