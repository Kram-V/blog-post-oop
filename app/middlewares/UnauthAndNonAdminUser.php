<?php

namespace App\Middlewares;

use App\Services\Auth as ServicesAuth;
use Core\Middleware;
use Core\Router;

class UnauthAndNonAdminUser implements Middleware {
  public function handle(callable $next) {
    $user = ServicesAuth::user();

    if ($user && $user->role === 'admin') {
      Router::unauthorized();
    }

    return $next;
  }
}