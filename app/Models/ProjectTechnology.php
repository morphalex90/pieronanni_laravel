<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ProjectTechnologyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Pivot model so attach/detach/sync fire model events; plain pivot writes
 * bypass the Project and Technology observers and leave cached data stale.
 */
#[ObservedBy(ProjectTechnologyObserver::class)]
final class ProjectTechnology extends Pivot
{
    public $timestamps = false;
}
