<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | User Must Be Authenticated
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | User Must Be Active
        |--------------------------------------------------------------------------
        */

        if ((int) $user->status !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is not active.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Admin Access Only
        |--------------------------------------------------------------------------
        */

        if ($user->user_type !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Admin access required.',
            ], 403);
        }

        return $next($request);
    }
}