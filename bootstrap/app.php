<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Sentry\Laravel\Integration;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            if (! app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [500, 503, 404, 403])) {
                if (! $request->hasSession()) {
                    $startSession = app(\Illuminate\Session\Middleware\StartSession::class);
                    $errorsFromSession = app(\Illuminate\View\Middleware\ShareErrorsFromSession::class);
                    $encryptCookies = app(\Illuminate\Cookie\Middleware\EncryptCookies::class);
                    $addQueuedCookiesToResponse = app(\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class);
                    $handleInertiaRequests = app(\App\Http\Middleware\HandleInertiaRequests::class);
                    $addQueuedCookiesToResponse = app(\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class);

                    return $encryptCookies->handle($request, function ($request) use ($addQueuedCookiesToResponse, $startSession, $errorsFromSession, $handleInertiaRequests, $response) {
                        return $addQueuedCookiesToResponse->handle($request, function ($request) use ($startSession, $errorsFromSession, $handleInertiaRequests, $response) {
                            return $startSession->handle($request, function ($request) use ($errorsFromSession, $handleInertiaRequests, $response) {
                                return $errorsFromSession->handle($request, function ($request) use ($handleInertiaRequests, $response) {
                                    return $handleInertiaRequests->handle($request, function ($request) use ($response) {
                                        return Inertia::render('error', ['status' => $response->getStatusCode()])->toResponse($request)->setStatusCode($response->getStatusCode());
                                    });
                                });
                            });
                        });
                    });
                } else {
                    return Inertia::render('error', ['status' => $response->getStatusCode()])->toResponse($request)->setStatusCode($response->getStatusCode());
                }
            } elseif ($response->getStatusCode() === 419) {
                return back()->with([
                    'message' => 'The page expired, please try again.',
                ]);
            }

            return $response;
        });

        Integration::handles($exceptions);
    })->create();
