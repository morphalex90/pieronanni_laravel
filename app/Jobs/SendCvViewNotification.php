<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Click;
use DeviceDetector\DeviceDetector;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

/**
 * Notify the Telegram channel that the CV was viewed, off the request path so
 * a slow or failing Telegram API never delays the PDF response.
 */
final class SendCvViewNotification implements ShouldQueue
{
    use Queueable;

    public const CHAT_ID = '-1002351275552';

    public int $tries = 3;

    /**
     * @var list<int>
     */
    public array $backoff = [10, 60];

    public function __construct(public Click $click) {}

    public function handle(): void
    {
        $dd = new DeviceDetector($this->click->user_agent);
        $dd->parse();

        if ($dd->isBot()) {
            return;
        }

        $info = [
            'clientInfo' => $dd->getClient(),
            'osInfo' => $dd->getOs(),
            'device' => $dd->getDeviceName(),
            'brand' => $dd->getBrandName(),
            'model' => $dd->getModel(),
        ];

        $message = "PieroNanni - CV\n\n";

        if ($this->click->country !== null) {
            $message .= '- ' . $this->click->country->name . "\n\n";
        }

        $message .= print_r($info, true);

        Http::timeout(10)
            ->get('https://api.telegram.org/bot' . config('services.telegram.key') . '/sendMessage', [
                'chat_id' => self::CHAT_ID,
                'text' => $message,
            ])
            ->throw();
    }
}
