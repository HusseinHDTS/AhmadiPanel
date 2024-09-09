<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('usrapi')->user();

        // Check if the user's status is "active"
        if ($user && $user->status !== 'active') {
            return response()->json(['message' => 'Your account is not active.'], 403);
        }

        return $next($request);
    }
}
