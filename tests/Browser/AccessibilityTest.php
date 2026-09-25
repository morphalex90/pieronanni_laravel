<?php

declare(strict_types=1);

use App\Models\Job;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Support\Facades\Vite;
use Pest\Browser\Api\On;
use Pest\Browser\Api\PendingAwaitablePage;

/**
 * Runs axe-core against the page, limited to WCAG 2.x rules up to level AAA.
 *
 * The plugin's assertNoAccessibilityIssues() calls axe with its defaults, which
 * leave the AAA rules (e.g. color-contrast-enhanced) disabled, so the tags are
 * passed explicitly here.
 */
function assertMeetsWcagAaa(PendingAwaitablePage|On $page): void
{
    $violations = $page->script(<<<'JS'
        async () => {
            const results = await window.axe.run(document, {
                runOnly: {
                    type: 'tag',
                    values: ['wcag2a', 'wcag2aa', 'wcag2aaa', 'wcag21a', 'wcag21aa', 'wcag22aa'],
                },
            });

            return results.violations.map((violation) => ({
                id: violation.id,
                help: violation.help,
                targets: violation.nodes.map((node) => node.target.join(' ')),
            }));
        }
    JS);

    $report = collect($violations)
        ->map(fn (array $violation): string => sprintf(
            "[%s] %s\n    %s",
            $violation['id'],
            $violation['help'],
            implode("\n    ", $violation['targets']),
        ))
        ->implode("\n");

    expect($violations)->toBeEmpty("WCAG AAA violations:\n" . $report);
}

beforeEach(function (): void {
    // Audit the page as the browser really renders it: the base TestCase disables
    // Vite, and the dev/SSR servers are not guaranteed to be running, so load the
    // built bundle (`npm run build`) and let React render client-side.
    $this->withVite();
    Vite::useHotFile(storage_path('framework/testing/vite.hot'));
    config(['inertia.ssr.enabled' => false]);

    $job = Job::factory()->create();

    Project::factory()
        ->for($job)
        ->hasAttached(Technology::factory()->state(['name' => 'Laravel']))
        ->create(['title' => 'Worcester Bosch', 'description' => str_repeat('word ', 60)]);
});

it('meets WCAG AAA on desktop', function (string $path): void {
    $page = visit($path);

    $page->assertNoJavaScriptErrors();

    assertMeetsWcagAaa($page);
})->with('public pages');

it('meets WCAG AAA on mobile', function (string $path): void {
    $page = visit($path)->on()->mobile();

    assertMeetsWcagAaa($page);
})->with('public pages');

dataset('public pages', [
    'home' => '/',
    'about' => '/about',
    'projects' => '/projects',
    'project' => '/projects/worcester-bosch',
    'freelance' => '/freelance-laravel-developer-london',
    'contact' => '/contact',
    'privacy policy' => '/privacy-policy',
    'cookie policy' => '/cookie-policy',
    'not found' => '/this-page-does-not-exist',
]);
