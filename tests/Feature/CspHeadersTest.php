<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Route;

beforeEach(function (): void {
    config()->set('csp.enabled', true);
    config()->set('app.debug', false);
});

it('applies the relaxed Horizon policy on Horizon routes', function (): void {
    $user = User::factory()->create(['email' => 'someone@gmail.com']);

    $policy = (string) $this->actingAs($user)
        ->get('horizon/dashboard')
        ->headers->get('Content-Security-Policy');

    expect(str_contains($policy, "img-src 'self' data:"))->toBeTrue();
    expect(str_contains($policy, 'https://fonts.bunny.net'))->toBeTrue();
    expect(str_contains($policy, "script-src 'self' 'unsafe-inline' 'unsafe-eval'"))->toBeTrue();
    expect(str_contains($policy, 'nonce-'))->toBeFalse();
});

it('applies the application policy outside Horizon', function (): void {
    Route::middleware('web')->get('csp-probe', fn () => 'ok');

    $policy = (string) $this->get('csp-probe')->headers->get('Content-Security-Policy');

    expect(str_contains($policy, 'nonce-'))->toBeTrue();
    expect(str_contains($policy, 'https://fonts.bunny.net'))->toBeFalse();
});

it('denies Horizon to guests instead of erroring', function (): void {
    $this->get('horizon/dashboard')->assertForbidden();
});
