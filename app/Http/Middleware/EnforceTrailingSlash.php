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

        // Target /services/* routes specifically (works both with root and subfolder like /demo)
        if ($request->is('services*')) {
            $path = parse_url($request->getRequestUri(), PHP_URL_PATH) ?? '';

            // Check if the actual requested URL path already ends with slash
            if (!str_ends_with($path, '/')) {
                $targetUrl = rtrim($request->url(), '/') . '/';
                $queryString = $request->getQueryString();
                if (!empty($queryString)) {
                    $targetUrl .= '?' . $queryString;
                }

                return redirect()->to($targetUrl, 301);
            }
        }

        return $next($request);
    }
}
