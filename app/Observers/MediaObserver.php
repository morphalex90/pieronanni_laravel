<?php

declare(strict_types=1);

namespace App\Observers;

use App\Actions\PurgeCache;
use App\Http\Controllers\ImageController;
use App\Models\Media;

final class MediaObserver
{
    public function created(): void
    {
        PurgeCache::handle(Media::class);
        ImageController::purgeEncodedCache();
    }

    public function updated(): void
    {
        PurgeCache::handle(Media::class);
        ImageController::purgeEncodedCache();
    }

    public function deleted(): void
    {
        PurgeCache::handle(Media::class);
        ImageController::purgeEncodedCache();
    }
}
