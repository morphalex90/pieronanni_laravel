<?php

declare(strict_types=1);

use App\Mail\Contact as MailContact;
use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    Mail::fake();
});

function fakeRecaptcha(array $payload = []): void
{
    config()->set('services.recaptcha.secret', 'test-secret');

    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response(array_merge([
            'success' => true,
            'action' => 'contact',
            'score' => 0.9,
        ], $payload)),
    ]);
}

function contactPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'Hello, this is a test message!',
        'privacy' => 1,
    ], $overrides);
}

it('saves the contact form data in DB', function () {
    $data = contactPayload();

    $response = $this->post(route('contact.store'), $data, [
        'HTTP_USER_AGENT' => 'TestAgent',
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $response->assertSessionHas('success', "Thank you! I'll get back to you shortly");

    expect(Contact::count())->toBe(1);

    $contact = Contact::first();

    expect($contact->name)->toBe($data['name'])
        ->and($contact->email)->toBe($data['email'])
        ->and($contact->message)->toBe($data['message'])
        ->and($contact->user_agent)->toBe('TestAgent');
});

it('queues the notification email with only validated input', function () {
    $this->post(route('contact.store'), contactPayload([
        'is_admin' => true,
        'cc' => 'attacker@example.com',
    ]));

    Mail::assertQueued(MailContact::class, function (MailContact $mail) {
        expect($mail->data)->toBe([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello, this is a test message!',
            'privacy' => 1,
        ]);

        return $mail->hasTo('piero.nanni@gmail.com')
            && $mail->hasReplyTo('john@example.com');
    });

    Mail::assertNothingSent();
});

it('rejects invalid contact submissions', function (array $overrides, string $invalidField) {
    $payload = contactPayload($overrides);

    $response = $this->post(route('contact.store'), $payload);

    $response->assertSessionHasErrors($invalidField);

    expect(Contact::count())->toBe(0);
    Mail::assertNothingQueued();
})->with([
    'missing name' => [['name' => ''], 'name'],
    'missing email' => [['email' => ''], 'email'],
    'malformed email' => [['email' => 'not-an-email'], 'email'],
    'missing message' => [['message' => ''], 'message'],
    'message over 1000 characters' => [['message' => str_repeat('a', 1001)], 'message'],
    'privacy not accepted' => [['privacy' => 0], 'privacy'],
]);

it('throttles repeated contact submissions from the same address', function () {
    foreach (range(1, 5) as $ignored) {
        $this->post(route('contact.store'), contactPayload())->assertRedirect();
    }

    $this->post(route('contact.store'), contactPayload())->assertStatus(429);

    expect(Contact::count())->toBe(5);
});

it('accepts a submission with a valid reCAPTCHA token', function () {
    fakeRecaptcha();

    $response = $this->post(route('contact.store'), contactPayload([
        'recaptcha_token' => 'token-from-google',
    ]));

    $response->assertSessionHasNoErrors();

    expect(Contact::count())->toBe(1);

    Mail::assertQueued(MailContact::class, function (MailContact $mail) {
        expect($mail->data)->not->toHaveKey('recaptcha_token');

        return true;
    });

    Http::assertSent(fn ($request) => $request['secret'] === 'test-secret'
        && $request['response'] === 'token-from-google');
});

it('rejects a submission when reCAPTCHA is configured but no token is sent', function () {
    fakeRecaptcha();

    $this->post(route('contact.store'), contactPayload())
        ->assertSessionHasErrors('recaptcha_token');

    expect(Contact::count())->toBe(0);
    Mail::assertNothingQueued();
});

it('rejects a submission when reCAPTCHA verification fails', function (array $payload) {
    fakeRecaptcha($payload);

    $this->post(route('contact.store'), contactPayload([
        'recaptcha_token' => 'token-from-google',
    ]))->assertSessionHasErrors('recaptcha_token');

    expect(Contact::count())->toBe(0);
    Mail::assertNothingQueued();
})->with([
    'unsuccessful verification' => [['success' => false]],
    'score below the threshold' => [['score' => 0.1]],
    'action mismatch' => [['action' => 'login']],
]);
