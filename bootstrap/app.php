<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle Model Not Found (e.g., Course not found via route model binding)
        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Resource not found'
                ], 404);
            }

            return response()->view('errors.404', ['exception' => $e], 404);
        });

        // Handle 404 Not Found
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Resource not found'
                ], 404);
            }

            return response()->view('errors.404', ['exception' => $e], 404);
        });

        // Handle 403 Forbidden
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Access denied'
                ], 403);
            }

            return response()->view('errors.403', ['exception' => $e], 403);
        });

        // Handle 503 Service Unavailable
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Service unavailable'
                ], 503);
            }

            return response()->view('errors.503', ['exception' => $e], 503);
        });

        // Handle general exceptions
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Server error',
                    'error' => config('app.debug') ? $e->getMessage() : 'An error occurred'
                ], 500);
            }

            // Only show custom 500 page in production
            if (!config('app.debug') && $e instanceof \Exception && $e->getCode() >= 500) {
                return response()->view('errors.500', ['exception' => $e], 500);
            }

            return null; // Fall back to default error handler
        });
    })->create();
