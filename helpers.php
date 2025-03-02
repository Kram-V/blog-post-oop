<?php

use App\Services\Authorization;
use App\Services\CSRF;

if (!function_exists('csrf_token')) {
  function csrf_token(): string {
    $tokenField = CSRF::getTokenFieldName();
    $token = CSRF::getToken();
    return <<<TAG
      <input type="hidden" name="$tokenField" value="$token">
    TAG;
  }
}

if (!function_exists('check')) {
  function check(string $action, object $resource = null): bool {
      return Authorization::check($action, $resource);
  }
}

if (!function_exists('e')) {
  function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }
}