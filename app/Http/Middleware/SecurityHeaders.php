<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $headers = config('csp.security_headers', []);

        if (! is_array($headers)) {
            return $response;
        }

        if (! empty($headers['strict_transport_security'])) {
            $response->headers->set('Strict-Transport-Security', $headers['strict_transport_security']);
        }

        if (! empty($headers['referrer_policy'])) {
            $response->headers->set('Referrer-Policy', $headers['referrer_policy']);
        }

        if (! empty($headers['permissions_policy'])) {
            $response->headers->set('Permissions-Policy', $headers['permissions_policy']);
        }

        return $response;
    }
}
