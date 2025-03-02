<?php

namespace App\Models;

use Core\App;
use Core\Model;

class Comment extends Model {
  protected static $table = 'comments';

  public $id;
  public $user_id;
  public $post_id;
  public $content;
  public $created_at;
  public $user_name;

  public static function post($postId): array {
    $db = App::get('database');

    return $db->fetchAll(
      "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC",
      [$postId],
      static::class
    );
  }

  public static function getRecent(int $limit): array {
    $db = App::get('database');

    return $db->fetchAll(
      "SELECT * FROM comments ORDER BY created_at DESC LIMIT ?",
      [$limit],
      static::class
    );
  }

  public static function count(): int { 
    $db = App::get('database');

    $query = 'SELECT COUNT(*)  FROM ' . static::$table;
    $params = [];

    return (int) $db->query($query, $params)->fetchColumn();
  }

  public static  function getCommentsByPostId($postId) {
    $db = App::get('database');

    $query = 'SELECT comments.*, users.name AS user_name  FROM ' . static::$table . ' INNER JOIN users ON comments.user_id = users.id WHERE comments.post_id = ? ORDER BY created_at DESC';
    $params = [$postId];

    return $db->fetchAll($query, $params, static::class);
  }
} 