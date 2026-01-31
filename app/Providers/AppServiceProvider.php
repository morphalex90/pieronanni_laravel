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
use Carbon\CarbonImmutable;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
            'royal' => Color::generateV3Palette('#ff1493'),
        ]);

        Job::observe(JobObserver::class);
        Click::observe(ClickObserver::class);
        Media::observe(MediaObserver::class);
        Project::observe(ProjectObserver::class);
        Contact::observe(ContactObserver::class);
        Technology::observe(TechnologyObserver::class);

        $this->configureDefaults();
    }

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
            : null
        );
    }
}
