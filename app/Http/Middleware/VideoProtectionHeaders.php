<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoProtectionHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only apply to course module pages
        if (!$request->is('courses/module/*')) {
            return $response;
        }

        // Block browser-level screen capture permission
        $response->headers->set('Permissions-Policy', 'display-capture=(), camera=(), microphone=()');

        // Prevent the page from being embedded in iframes on other sites
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Block referrer leaking the video URL to external sites
        $response->headers->set('Referrer-Policy', 'no-referrer');

        // Prevent caching of protected content
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, private');
        $response->headers->set('Pragma', 'no-cache');

        return $response;
    }
}
