<?php

namespace App\Providers;

use App\Models\Click;
use App\Models\Contact;
use App\Observers\ClickObserver;
use App\Observers\ContactObserver;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
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
        Contact::observe(ContactObserver::class);

        Vite::prefetch(concurrency: 3);

        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }

        DB::prohibitDestructiveCommands($this->app->isProduction());
        Model::shouldBeStrict();
    }
}
