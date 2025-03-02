<?php

namespace App\Services;

use App\Models\Post;
use Core\Router;

class Authorization {
  public static function verify(string $action, ?object $resource = null): void {
    if (!static::check($action, $resource)) {
      Router::forbidden();
    }
  }

  public static function check(string $action, ?object $resource = null): bool {
    $user = Auth::user();

    if (!$user) {
      return false;
    }

    if 
      (
        ($user->role === 'admin' && $action === 'dashboard') || 
        ($user->role === 'admin' && $action === 'edit_admin_role') ||
        ($user->role === 'admin' && $action === 'update_admin_role') ||
        ($user->role === 'admin' && $action === 'all_posts_admin_role') ||
        ($user->role === 'admin' && $action === 'delete_post_admin_role')  ||
        ($user->role === 'admin' && $action === 'get_users_admin_role') ||
        ($user->role === 'admin' && $action === 'make_user_admin') ||
        ($user->role === 'admin' && $action === 'make_user_nonadmin') 
      ) 
      {
        return true;
      }

    return match($action) {
      'comment' => $user->role === 'non-admin',
      'show_create_post_page' => $user->role === 'non-admin',
      'create_post' => true,
      'edit_post', 'update_post', 'delete_post' => $resource instanceof Post && $user->id === $resource->user_id && $user->role === 'non-admin',
      default => false,
    };
  }
}