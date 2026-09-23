<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\SendCvViewNotification;
use App\Models\Click;
use App\Models\Country;

final class ClickObserver
{
    public function creating(Click $click): void
    {
        if (! app()->environment('local') && request()->headers->has('CF-IPCountry')) {
            $country = Country::where('code', request()->header('CF-IPCountry'))->first();
            if ($country !== null) {
                $click->country_id = $country->id;
            }
        }
    }

    public function created(Click $click): void
    {
        SendCvViewNotification::dispatch($click)->afterCommit();
    }
}
