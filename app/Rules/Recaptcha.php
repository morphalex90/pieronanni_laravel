<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Translation\PotentiallyTranslatedString;
use Throwable;

/**
 * Verifies a reCAPTCHA v3 token against Google's siteverify endpoint.
 *
 * The rule passes silently when no secret is configured, so local and test
 * environments keep working without Google credentials.
 */
final class Recaptcha implements ValidationRule
{
    private const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct(private string $expectedAction) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = (string) config('services.recaptcha.secret');

        if ($secret === '') {
            return;
        }

        if (! is_string($value) || $value === '') {
            $fail('The captcha verification failed. Please try again.');

            return;
        }

        try {
            $response = Http::asForm()
                ->timeout(5)
                ->post(self::VERIFY_URL, [
                    'secret' => $secret,
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ])
                ->throw()
                ->json();
        } catch (Throwable $e) {
            report($e);

            $fail('The captcha could not be verified. Please try again.');

            return;
        }

        if (! $this->isValidResponse($response)) {
            $fail('The captcha verification failed. Please try again.');
        }
    }

    /**
     * @param  array{success?: bool, action?: string, score?: float|int}|mixed  $response
     */
    private function isValidResponse(mixed $response): bool
    {
        if (! is_array($response) || ($response['success'] ?? false) !== true) {
            return false;
        }

        if (($response['action'] ?? null) !== $this->expectedAction) {
            return false;
        }

        $minimumScore = (float) config('services.recaptcha.min_score', 0.5);

        return (float) ($response['score'] ?? 0) >= $minimumScore;
    }
}
