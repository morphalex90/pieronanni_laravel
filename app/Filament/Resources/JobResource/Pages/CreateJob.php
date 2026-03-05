<?php

declare(strict_types=1);

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;
}
