<?php

namespace App\Observers;

use App\Models\Click;
use App\Models\Country;
use DeviceDetector\DeviceDetector;
use Exception;
use Illuminate\Support\Facades\Http;

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

    public function created(Click $click): void
    {
        $info = [];

        $dd = new DeviceDetector($click->user_agent);
        $dd->parse();

        if ($dd->isBot()) {
            $info['botInfo'] = $dd->getBot();
        } else {
            $info['clientInfo'] = $dd->getClient();
            $info['osInfo'] = $dd->getOs();
            $info['device'] = $dd->getDeviceName();
            $info['brand'] = $dd->getBrandName();
            $info['model'] = $dd->getModel();
        }

        $message = "PieroNanni - CV\n\n";

        if ($click->country != null) {
            $message .= '- ' . $click->country->name . "\n\n";
        }

        $message .= print_r($info,1);

        $apiToken = config('services.telegram.key');

        $data = [
            'chat_id' => '-1002351275552',
            'text' => $message,
        ];

        try {
            $response = Http::get('https://api.telegram.org/bot' . $apiToken . '/sendMessage?' . http_build_query($data));
            // dd($response->body());
        } catch (Exception $e) {
            // dd($e);
        }
    }
}
