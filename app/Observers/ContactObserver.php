<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Contact;
use App\Models\Country;

final class ContactObserver
{
    public function creating(Contact $contact): void
    {
        if (! app()->environment('local') && request()->headers->has('CF-IPCountry')) {
            $country = Country::where('code', request()->header('CF-IPCountry'))->first();
            if ($country !== null) {
                $contact->country_id = $country->id;
            }
        }
    }
}
