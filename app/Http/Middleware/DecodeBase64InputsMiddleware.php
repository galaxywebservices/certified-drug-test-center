<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DecodeBase64InputsMiddleware
{
    /**
     * Decode any Base64 encoded form fields (ending in _b64) sent by the client
     * to safely bypass web application firewalls (ModSecurity CRS) when saving HTML content.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $decoded = [];
        foreach ($request->all() as $key => $value) {
            if (is_string($value) && str_ends_with($key, '_b64')) {
                $originalKey = substr($key, 0, -4);
                $decodedValue = base64_decode($value, true);
                if ($decodedValue !== false) {
                    $decoded[$originalKey] = $decodedValue;
                }
            }
        }

        if (!empty($decoded)) {
            $request->merge($decoded);
        }

        return $next($request);
    }
}
