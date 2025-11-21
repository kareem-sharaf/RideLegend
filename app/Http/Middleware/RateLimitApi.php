<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitApi
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'api:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 60)) { // 60 requests per minute
            return response()->json([
                'message' => 'Too many requests. Please try again later.',
            ], 429);
        }

        RateLimiter::hit($key, 60); // 60 seconds

        $response = $next($request);

        $response->headers->set('X-RateLimit-Limit', '60');
        $response->headers->set('X-RateLimit-Remaining', RateLimiter::remaining($key, 60));

        return $response;
    }
}

