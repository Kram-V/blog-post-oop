<?php

namespace App\Services;

use App\Models\RememberToken;
use App\Models\User;


class RememberMe {
  private const COOKIE_NAME = 'remember_token';

  public static function createToken(int $userId): RememberToken {
    $rememberToken = RememberToken::createForUser($userId);

    static::setCookie($rememberToken->token);    
    return $rememberToken;
  }

  public static function user(): ?User {
    $tokenString = $_COOKIE[self::COOKIE_NAME] ?? null;

    if (!$tokenString) {
      return null;
    }

    $rememberToken = RememberToken::findValid($tokenString);

    if (!$rememberToken) {
      return null;
    }

    $user = User::find($rememberToken->user_id);

    if ($user){
      static::rotateToken($rememberToken);
    }

    return $user;
  }

  public static function clearToken(): void {
    $tokenString = $_COOKIE[static::COOKIE_NAME] ?? null;

    if ($tokenString) {
      $token = RememberToken::findValid($tokenString);

      if ($token) {
        $token->delete();
      }
    }

    static::removeCookie();
  }

  private static function setCookie(string $token): void {
    $expiry = time() + RememberToken::TOKEN_LIFETIME;

    setcookie(static::COOKIE_NAME, $token, $expiry, "/", "", true, true);
  }

  private static function removeCookie(): void {
    setcookie(static::COOKIE_NAME, '', time() - 3600, "/", "", true, true);
  }

  private static function rotateToken(RememberToken $rememberToken): void {
    $rememberToken->rotate();

    static::setCookie($rememberToken->token);
  }
}