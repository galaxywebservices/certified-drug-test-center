<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanonicalRedirectMiddleware
{
    /**
     * Handle an incoming request.
     * Enforce strict 301 canonicalization:
     * 1. Strip 'www.' from hostname (redirect to non-www canonical host)
     * 2. Strip trailing slash from URI path (except root '/')
     * Resolves both in a single 301 hop to eliminate duplicate crawl variants.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only canonicalize safe GET / HEAD requests
        if (!$request->isMethodSafe()) {
            return $next($request);
        }

        $host = $request->getHost();
        $path = $request->getPathInfo(); // Always starts with '/'
        $needsRedirect = false;
        $targetHost = $host;

        // 1. Detect and strip www.
        if (str_starts_with(strtolower($host), 'www.')) {
            $targetHost = substr($host, 4);
            $needsRedirect = true;
        }

        // 2. Detect and strip trailing slash (ignore root '/')
        $targetPath = $path;
        if ($path !== '/' && str_ends_with($path, '/')) {
            $targetPath = rtrim($path, '/');
            $needsRedirect = true;
        }

        if ($needsRedirect) {
            $scheme = $request->getScheme();
            // In production or on live host, always enforce https
            if (!app()->environment('local', 'testing') || $request->isSecure()) {
                $scheme = 'https';
            }

            $port = $request->getPort();
            $portString = '';
            // Only preserve non-standard ports for local development
            if ($port && !in_array($port, [80, 443]) && app()->environment('local', 'testing')) {
                $portString = ':' . $port;
            }

            $targetUrl = $scheme . '://' . $targetHost . $portString . $targetPath;
            $queryString = $request->getQueryString();
            if (!empty($queryString)) {
                $targetUrl .= '?' . $queryString;
            }

            return redirect()->to($targetUrl, 301);
        }

        return $next($request);
    }
}
