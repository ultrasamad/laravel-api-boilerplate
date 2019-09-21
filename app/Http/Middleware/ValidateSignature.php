<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Vaidate signature specifically for api request
 */
class ValidateSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasValidSignature()) {
            return $next($request);
        }
        
        return response()->json([
            'error' => [
                'message'   => 'Invalid signature',
            ]
        ], 403);
    }
}
