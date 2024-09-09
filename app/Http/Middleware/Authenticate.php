<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
  /**
   * Get the path the user should be redirected to when they are not authenticated.
   */
  protected function redirectTo(Request $request): ?string
  {
    if ($request->expectsJson()) {
      return null; // This ensures no redirection happens
    }

    return route('auth-login-basic'); // Redirects to the login route for web-based requests
  }

  /**
   * Handle an unauthenticated user.
   */
  protected function unauthenticated($request, array $guards)
  {
    if ($request->expectsJson()) {
      abort(response()->json(['message' => 'Unauthenticated.'], 401));
    }

    parent::unauthenticated($request, $guards);
  }
}