<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class JobObserver
{
    public function created(): void
    {
        Cache::forget('jobs');
    }

    public function updated(): void
    {
        Cache::forget('jobs');
    }

    public function deleted(): void
    {
        Cache::forget('jobs');
    }
}
