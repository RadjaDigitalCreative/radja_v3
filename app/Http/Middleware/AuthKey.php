<?php

namespace App\Http\Middleware;

use Closure;

class AuthKey
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('APP_KEY');

        if ($token != '$2y$10$ry4IIgdDDFMPnKEa0CyRlOYx5s3HKaHBQ2m1Av9uGfdH9RUkSpDve') {
           return response()->json([
                'message' => 'App key not found'
           ], 401);
        }
        return $next($request);
    }
}
