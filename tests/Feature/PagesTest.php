<?php

declare(strict_types=1);

use App\Models\Click;
use App\Models\Job;
use App\Models\Project;
use App\Models\Technology;
use Inertia\Testing\AssertableInertia;

it('renders the homepage', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page->component('welcome'));
});

it('renders the about page with the jobs, newest first', function () {
    $older = Job::factory()->create(['started_at' => now()->subYears(3)]);
    $newer = Job::factory()->create(['started_at' => now()->subYear()]);

    $this->get(route('about'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('about')
            ->has('jobs', 2)
            ->where('jobs.0.id', $newer->id)
            ->where('jobs.1.id', $older->id)
        );
});

it('renders the projects page with technologies and nested projects', function () {
    $job = Job::factory()->create();
    $project = Project::factory()->for($job)->create();
    $technology = Technology::factory()->create(['name' => 'Laravel']);
    $project->technologies()->attach($technology);

    $this->get(route('projects'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('projects')
            ->has('technologies', 1)
            ->where('technologies.0.name', 'Laravel')
            ->has('allJobs', 1)
            ->has('allJobs.0.projects', 1)
            ->where('allJobs.0.projects.0.id', $project->id)
            ->has('allJobs.0.projects.0.technologies', 1)
        );
});

it('renders the contact page', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page->component('contact'));
});

it('redirects the legacy cv.pdf path to the cv route', function () {
    $this->get('/cv.pdf')->assertRedirect('/cv');
});

it('redirects the login route to the admin panel', function () {
    $this->get(route('login'))->assertRedirect('admin/login');
});

it('serves the mpdf cv inline through the response pipeline', function () {
    Job::factory()->has(Project::factory()->count(2))->create();

    $response = $this->get(route('cv-old'));

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/pdf');
    $response->assertHeader('Content-Disposition', 'inline; filename="cv_piero_nanni.pdf"');

    expect($response->getContent())->toStartWith('%PDF-');
});

it('records a click and serves the browsershot cv', function () {
    Job::factory()->has(Project::factory()->count(2))->create();

    $response = $this->get(route('cv'));

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/pdf');

    expect(Click::count())->toBe(1);
})->skip(
    fn (): bool => ! env('BROWSERSHOT_TESTS'),
    'Set BROWSERSHOT_TESTS=1 to run the Chrome-dependent CV test.'
);

it('throttles repeated cv requests from the same address', function () {
    Job::factory()->create();

    foreach (range(1, 20) as $ignored) {
        $this->get(route('cv-old'))->assertOk();
    }

    $this->get(route('cv-old'))->assertStatus(429);
});
