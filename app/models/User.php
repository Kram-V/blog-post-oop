<?php

namespace App\Models;

use Core\App;
use Core\Model;

class User extends Model {
  protected static $table = 'users';

  public $id;
  public $name;
  public $email;
  public $password;
  public $role;
  public $created_at;

  public static function findByEmail(string $email): ?User {
    $db = App::get('database');

    $query = "SELECT * FROM users WHERE email = ?"; 
    $params = [$email];

    $result = $db->fetch($query, $params, static::class);

    return $result ? $result : null;
  }
}