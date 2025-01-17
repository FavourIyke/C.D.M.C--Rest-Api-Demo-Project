<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RateLimitJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->getStatusCode() == 429) {
            return response()->json([
                'status' => false,
                'message' => 'Too many requests. Please try again later.',
                'data' => null
            ], 429);  
        }

        return $response;
    }
}
