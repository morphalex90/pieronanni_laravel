<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class TechnologyObserver
{
    public function created(): void
    {
        Cache::forget('technologies');
    }

    public function updated(): void
    {
        Cache::forget('technologies');
    }

    public function deleted(): void
    {
        Cache::forget('technologies');
    }
}
