<?php

namespace App\Providers;

use App\Models\Click;
use App\Models\Contact;
use App\Models\Job;
use App\Models\Media;
use App\Models\Project;
use App\Models\Technology;
use App\Observers\ClickObserver;
use App\Observers\ContactObserver;
use App\Observers\JobObserver;
use App\Observers\MediaObserver;
use App\Observers\ProjectObserver;
use App\Observers\TechnologyObserver;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
// use Illuminate\Support\Facades\Vite;
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

        Job::observe(JobObserver::class);
        Click::observe(ClickObserver::class);
        Media::observe(MediaObserver::class);
        Project::observe(ProjectObserver::class);
        Contact::observe(ContactObserver::class);
        Technology::observe(TechnologyObserver::class);

        // Vite::prefetch(concurrency: 3);

        if (App::isProduction()) {
            URL::forceScheme('https');
        }

        DB::prohibitDestructiveCommands(App::isProduction());
        // Model::shouldBeStrict();
    }
}
