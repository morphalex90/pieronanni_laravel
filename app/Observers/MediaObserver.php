<?php

declare(strict_types=1);

namespace App\Observers;

use App\Actions\PurgeCache;

final class MediaObserver
{
    public function created(): void
    {
        PurgeCache::handle();
    }

    public function updated(): void
    {
        PurgeCache::handle();
    }

    public function deleted(): void
    {
        PurgeCache::handle();
    }
}
