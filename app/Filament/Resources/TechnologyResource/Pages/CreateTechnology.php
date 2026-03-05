<?php

declare(strict_types=1);

namespace App\Filament\Resources\TechnologyResource\Pages;

use App\Filament\Resources\TechnologyResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateTechnology extends CreateRecord
{
    protected static string $resource = TechnologyResource::class;
}
