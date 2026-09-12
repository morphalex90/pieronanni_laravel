<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Page assertions target the Inertia payload, not the built bundle, so
        // the suite does not depend on a fresh `npm run build`.
        $this->withoutVite();

        Http::fake([
            'https://fonts.googleapis.com/*' => Http::response('', 200),
        ]);
    }
}
