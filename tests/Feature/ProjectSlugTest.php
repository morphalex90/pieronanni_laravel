<?php

declare(strict_types=1);

use App\Models\Job;
use App\Models\Project;

it('generates a slug from the title, suffixing titles already taken', function () {
    $first = Project::factory()->for(Job::factory())->create(['title' => 'Mathys & Squire']);
    $second = Project::factory()->for(Job::factory())->create(['title' => 'Mathys & Squire']);

    expect($first->slug)->toBe('mathys-squire');
    expect($second->slug)->toBe('mathys-squire-2');
});

it('keeps a slug that was set explicitly', function () {
    $project = Project::factory()->for(Job::factory())->create(['title' => 'Mathys & Squire', 'slug' => 'scalehub-quarter']);

    expect($project->slug)->toBe('scalehub-quarter');
});

it('regenerates the slug when it is cleared on update', function () {
    $project = Project::factory()->for(Job::factory())->create(['title' => 'Brompton', 'slug' => 'old-slug']);

    $project->update(['slug' => '']);

    expect($project->fresh()->slug)->toBe('brompton');
});
