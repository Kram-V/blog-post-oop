<?php

namespace App\Middlewares;

use App\Services\Auth as ServicesAuth;
use Core\Middleware;
use Core\Router;

class Redirect implements Middleware {
  public function handle(callable $next) {
    $user = ServicesAuth::user();

    if ($user !== null && $user->role === 'non-admin' && $_SERVER['REQUEST_URI'] === '/login') {
      Router::redirect('/');
    }

    if ($user !== null && $user->role === 'non-admin' && $_SERVER['REQUEST_URI'] === '/register') {
      Router::redirect('/');
    }


    if ($user !== null && $user->role === 'admin' && $_SERVER['REQUEST_URI'] === '/login') {
      Router::redirect('/admin/dashboard');
    }

    if ($user !== null && $user->role === 'admin' && $_SERVER['REQUEST_URI'] === '/register') {
      Router::redirect('/admin/dashboard');
    }

    return $next;
  }
}