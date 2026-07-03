<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    public function getContentTabIcon(): string
    {
        return 'heroicon-m-cog';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
