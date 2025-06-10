<?php

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('saves the contact form data in DB', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'Hello, this is a test message!',
        'privacy' => 1,
    ];

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
