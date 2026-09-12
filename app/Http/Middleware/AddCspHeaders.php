<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Support\Csp\HorizonPreset;
use Closure;
use Illuminate\Http\Request;
use Spatie\Csp\AddCspHeaders as SpatieAddCspHeaders;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies the application CSP, except on the Horizon dashboard, which needs
 * its own relaxed policy.
 *
 * @see HorizonPreset
 */
final class AddCspHeaders extends SpatieAddCspHeaders
{
    public function handle(Request $request, Closure $next, ?string $customPreset = null): Response
    {
        if ($customPreset === null && $this->isHorizonRequest($request)) {
            $customPreset = HorizonPreset::class;
        }

        return parent::handle($request, $next, $customPreset);
    }

    private function isHorizonRequest(Request $request): bool
    {
        $path = mb_trim((string) config('horizon.path', 'horizon'), '/');

        return $path !== '' && $request->is($path, $path . '/*');
    }
}
