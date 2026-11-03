<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceTrailingSlash
{
    /**
     * Handle an incoming request.
     * Enforces trailing slash on all programmatic /services/* routes to eliminate
     * redirect bounces and canonical confusion.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only enforce for GET / HEAD requests
        if (!$request->isMethodSafe()) {
            return $next($request);
        }

        $path = $request->getPathInfo(); // e.g. "/services/5-panel-drug-test/florida/orlando"

        // Target /services/* routes specifically
        if (str_starts_with($path, '/services')) {
            // Check if it already ends with slash
            if (!str_ends_with($path, '/')) {
                $targetUrl = rtrim($request->root() . $path, '/') . '/';
                $queryString = $request->getQueryString();
                if (!empty($queryString)) {
                    $targetUrl .= '?' . $queryString;
                }

                return redirect()->to($targetUrl, 301, [
                    'Cache-Control' => 'public, max-age=31536000',
                ]);
            }
        }

        return $next($request);
    }
}
