<?php

declare(strict_types=1);

namespace App\Filament\Resources\ClickResource\Pages;

use App\Filament\Resources\ClickResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListClicks extends ListRecords
{
    protected static string $resource = ClickResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
