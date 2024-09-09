<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
  /**
   * The URIs that should be excluded from CSRF verification.
   *
   * @var array<int, string>
   */
  protected $except = [
    //
  ];
  protected function addCookieToResponse($request, $response)
  {
    $response->headers->set('Content-Type', 'text/html; charset=UTF-8');

    return parent::addCookieToResponse($request, $response);
  }
}