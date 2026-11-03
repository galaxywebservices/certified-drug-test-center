<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class PseoPageCache
{
    public const CACHE_TTL_SECONDS = 604800; // 7 days

    /**
     * Handle an incoming request.
     * High-speed response caching for programmatic SEO endpoints.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only cache GET/HEAD requests on programmatic /services/* routes for guest visitors
        if (!$request->isMethodSafe() || !str_starts_with($request->getPathInfo(), '/services') || auth()->check()) {
            return $next($request);
        }

        // Avoid caching if query string contains session/transient parameters
        if ($request->hasAny(['preview', 'token', 'admin'])) {
            return $next($request);
        }

        $cacheKey = 'pseo_page:' . md5($request->getRequestUri());

        $cachedData = Cache::get($cacheKey);
        if ($cachedData && is_array($cachedData) && isset($cachedData['content'], $cachedData['status'])) {
            return response($cachedData['content'], $cachedData['status'])
                ->header('Content-Type', $cachedData['content_type'] ?? 'text/html; charset=UTF-8')
                ->header('X-Cache', 'HIT')
                ->header('X-Pseo-Cache', 'true');
        }

        $response = $next($request);

        // Only cache successful 200 responses
        if ($response->getStatusCode() === 200) {
            $content = $response->getContent();
            $contentType = $response->headers->get('Content-Type', 'text/html; charset=UTF-8');

            Cache::put($cacheKey, [
                'content' => $content,
                'status' => 200,
                'content_type' => $contentType,
            ], self::CACHE_TTL_SECONDS);

            $response->headers->set('X-Cache', 'MISS');
            $response->headers->set('X-Pseo-Cache', 'true');
        }

        return $response;
    }
}
