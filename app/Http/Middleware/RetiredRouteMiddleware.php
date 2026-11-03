<?php

namespace App\Http\Middleware;

use App\Models\RetiredRoute;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RetiredRouteMiddleware
{
    /**
     * Handle an incoming request.
     * Check if the requested URL has been retired or redirected.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uri = $request->getRequestUri();
        $path = $request->getPathInfo();

        $retired = RetiredRoute::where('legacy_url', $uri)
            ->orWhere('legacy_url', $path)
            ->orWhere('legacy_url', rtrim($path, '/'))
            ->orWhere('legacy_url', rtrim($path, '/') . '/')
            ->first();

        if ($retired) {
            if ($retired->action === '301' && !empty($retired->target_url)) {
                $target = $retired->target_url;
                if (!str_ends_with($target, '/') && !str_contains($target, '?') && !str_contains($target, '.')) {
                    $target .= '/';
                }
                return redirect($target, 301);
            }

            // HTTP 410 Gone: Explicitly signals to search crawlers that the page was permanently removed
            return response()
                ->view('errors.410', [
                    'pageTitle' => '410 - Location Permanently Retired | Certified Drug Test Centers',
                    'metaDescription' => 'This testing center or location URL has been retired. Search 20,000+ active partner centers nationwide.',
                ], 410)
                ->header('Cache-Control', 'public, max-age=86400');
        }

        return $next($request);
    }
}
