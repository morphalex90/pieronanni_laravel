<?php

namespace App\Observers;

use App\Actions\PurgeCache;

class FileObserver
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
