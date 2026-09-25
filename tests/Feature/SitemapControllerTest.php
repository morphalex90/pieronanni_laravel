<?php

declare(strict_types=1);

use App\Models\Job;
use App\Models\Project;

it('lists the static pages and only projects with enough content to index', function () {
    Project::factory()->for(Job::factory())->create(['title' => 'Stephenson Harwood', 'description' => str_repeat('word ', 60)]);
    Project::factory()->for(Job::factory())->create(['title' => 'Kobra PDF', 'description' => 'PDF service']);

    $response = $this->get('/sitemap.xml');

    $response->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

    $xml = simplexml_load_string($response->getContent());
    $xml->registerXPathNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $locations = array_map('strval', $xml->xpath('//s:url/s:loc'));

    expect($locations)->toBe([
        url('/') . '/',
        url('/about'),
        url('/projects'),
        url('/freelance-laravel-developer-london'),
        url('/contact'),
        url('/cv'),
        url('/projects/stephenson-harwood'),
    ]);
});
