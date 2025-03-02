<?php

namespace App\Services;

use App\Models\User;
use Core\Router;
use Core\View;

class Auth {
  // FOR REMEMBER ME FEATURE

  // public static function attempt(string $email, string $password, bool $remember): bool {
  //   $user = User::findByEmail($email);

  //   if ($user && password_verify($password, $user->password)) {
  //     session_regenerate_id(true);
  //     $_SESSION['user_id'] = $user->id; 

  //     if ($remember) {
  //       RememberMe::createToken($user->id);
  //     }

  //     return true; 
  //   }
  //   return false;
  // }

  public static function attempt(string $email, string $password): bool {
    $user = User::findByEmail($email);

    if ($user && password_verify($password, $user->password)) {
      session_regenerate_id(true);
      $_SESSION['user_id'] = $user->id; 

      return true; 
    }
    return false;
  }

  public static function user(): ?User {
    $userId = $_SESSION['user_id'] ?? null;

    if (!empty($userId)) {
      $user = User::find($userId);
      return $user;
    } 

    $user = RememberMe::user();
    return $user;
  }

  public static function logout(): void {
    session_destroy();
    RememberMe::clearToken();
  }
}