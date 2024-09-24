<?php

namespace App\Observers;

use App\Models\Click;
use App\Models\Country;

class ClickObserver
{
    public function creating(Click $click): void
    {
        if (! app()->environment('local') && request()->headers->has('CF-IPCountry')) {
            $country = Country::where('code', request()->header('CF-IPCountry'))->first();
            if ($country != null) {
                $click->country_id = $country->id;
            }
        }
    }
}
