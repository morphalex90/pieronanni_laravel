<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia;

beforeEach(function (): void {
    config(['app.debug' => false]);
});

it('renders the Inertia error page for a missing page', function () {
    $this->get('/this-page-does-not-exist')
        ->assertNotFound()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('error')
            ->where('status', 404));
});

it('keeps the JSON response for API requests', function () {
    $this->getJson('/this-page-does-not-exist')
        ->assertNotFound()
        ->assertHeader('content-type', 'application/json');
});

it('shows the debug exception page while debug mode is on', function () {
    config(['app.debug' => true]);

    $this->get('/this-page-does-not-exist')
        ->assertNotFound();

    expect($this->get('/this-page-does-not-exist')->headers->get('x-inertia'))->toBeNull();
});
