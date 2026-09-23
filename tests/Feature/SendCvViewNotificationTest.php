<?php

declare(strict_types=1);

use App\Jobs\SendCvViewNotification;
use App\Models\Click;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;

const DESKTOP_CHROME = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36';

it('queues the telegram notification when a cv view is recorded', function (): void {
    Queue::fake();

    $click = Click::create(['user_agent' => DESKTOP_CHROME]);

    Queue::assertPushed(SendCvViewNotification::class, fn (SendCvViewNotification $job): bool => $job->click->is($click));
});

it('sends the cv view to telegram for a human visitor', function (): void {
    Queue::fake();
    Http::fake();

    (new SendCvViewNotification(Click::create(['user_agent' => DESKTOP_CHROME])))->handle();

    Http::assertSent(fn (Request $request): bool => str_starts_with($request->url(), 'https://api.telegram.org/bot')
        && $request['chat_id'] === SendCvViewNotification::CHAT_ID
        && str_contains($request['text'], 'Chrome'));
});

it('does not notify telegram for bots', function (): void {
    Queue::fake();
    Http::fake();

    (new SendCvViewNotification(Click::create(['user_agent' => 'Googlebot/2.1 (+http://www.google.com/bot.html)'])))->handle();

    Http::assertNothingSent();
});

it('fails the job so it retries when telegram errors', function (): void {
    Queue::fake();
    Http::fake(['api.telegram.org/*' => Http::response(status: 500)]);

    (new SendCvViewNotification(Click::create(['user_agent' => DESKTOP_CHROME])))->handle();
})->throws(Illuminate\Http\Client\RequestException::class);
