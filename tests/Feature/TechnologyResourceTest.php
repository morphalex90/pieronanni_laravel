<?php

declare(strict_types=1);

use App\Filament\Resources\TechnologyResource;
use App\Filament\Resources\TechnologyResource\Pages\CreateTechnology;
use App\Filament\Resources\TechnologyResource\Pages\EditTechnology;
use App\Filament\Resources\TechnologyResource\Pages\ListTechnologies;
use App\Models\Technology;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;

beforeEach(function () {
    // The panel is normally resolved by path middleware; Livewire component
    // tests bypass routing, so select it explicitly.
    Filament::setCurrentPanel('admin');
});

it('redirects guests away from the technologies panel', function () {
    $this->get(TechnologyResource::getUrl('index'))
        ->assertRedirect(route('filament.admin.auth.login'));
});

describe('as a panel user', function () {
    beforeEach(function () {
        $this->actingAs(User::factory()->panelUser()->create());
    });

    it('lists the existing technologies', function () {
        $technologies = Technology::factory()->count(3)->create();

        Livewire::test(ListTechnologies::class)
            ->assertCanSeeTableRecords($technologies)
            ->assertCanRenderTableColumn('name')
            ->assertCanRenderTableColumn('key');
    });

    it('creates a technology', function () {
        Livewire::test(CreateTechnology::class)
            ->fillForm([
                'name' => 'Laravel',
                'key' => 'laravel',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(Technology::class, [
            'name' => 'Laravel',
            'key' => 'laravel',
        ]);
    });

    it('requires a name and a key', function () {
        Livewire::test(CreateTechnology::class)
            ->fillForm([
                'name' => null,
                'key' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'name' => 'required',
                'key' => 'required',
            ]);

        expect(Technology::count())->toBe(0);
    });

    it('updates a technology', function () {
        $technology = Technology::factory()->create();

        Livewire::test(EditTechnology::class, ['record' => $technology->getRouteKey()])
            ->fillForm(['name' => 'Renamed'])
            ->call('save')
            ->assertHasNoFormErrors();

        expect($technology->refresh()->name)->toBe('Renamed');
    });
});
