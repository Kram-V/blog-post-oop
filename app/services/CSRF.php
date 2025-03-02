<?php

namespace App\Services;

class CSRF {
  private const CSRF_TOKEN_LENGTH = 32;
  private const CSRF_TOKEN_LIFETIME = 30 * 60;
  private const CSRF_TOKEN_FIELD_NAME = '_token';

  public static function getToken(): string {
    if (!isset($_SESSION['csrf_token']) || static::isTokenExpired()) {
      return static::generateToken();
    }

    return $_SESSION['csrf_token']['token'];
  }

  public static function verify(?string $token = null): bool {
    $method = $_SERVER['REQUEST_METHOD'];

    if (in_array($method, ['GET', 'HEAD', 'OPTIONS'])) {
      return true;
    }

    $csrfToken = $token ?? $_POST[static::CSRF_TOKEN_FIELD_NAME] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

    if ($csrfToken && !static::isTokenExpired() && hash_equals($_SESSION['csrf_token']['token'], $csrfToken)) {
      static::generateToken();

      return true;
    }

    return false;
  }

  public static function getTokenFieldName(): string {
    return static::CSRF_TOKEN_FIELD_NAME;
  }

  private static function isTokenExpired(): bool {
    $expires = $_SESSION['csrf_token']['expires'];

    return !isset($expires) || time() > $expires;
  }

  private static function generateToken(): string {
    $token = bin2hex(random_bytes(static::CSRF_TOKEN_LENGTH));
    $_SESSION['csrf_token'] = [
      'token' => $token,
      'expires' => time() + self::CSRF_TOKEN_LIFETIME,
    ];

    return $token;
  }
}