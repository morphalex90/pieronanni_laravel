<?php

namespace App\Filament\Resources\TechnologyResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\TechnologyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTechnologies extends ListRecords
{
    protected static string $resource = TechnologyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
