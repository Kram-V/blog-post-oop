<?php

namespace App\Models;

use Core\App;
use Core\Model;

class Post extends Model {
  protected static $table = 'posts';

  public $id;
  public $user_id;
  public $title;
  public $content;
  public $views;
  public $created_at;

  public static function getRecent(int $limit): array {
    $db = App::get('database');

    return $db->fetchAll(
      "SELECT * FROM posts ORDER BY created_at DESC LIMIT ?",
      [$limit],
      static::class
    );
  }

  // public static function incrementViews($id): void {
  //   $db = App::get('database');

  //   $db->query(
  //     "UPDATE posts SET views = views + 1 WHERE id = ?",
  //     [$id],
  //   );
  // }

  public static function count(?string $search = null): int {
    $db = App::get('database');

    $query = 'SELECT COUNT(*)  FROM ' . static::$table;
    $params = [];

    if ($search) {
      $query .= ' WHERE title LIKE ?'; 
      $params = ["%{$search}%"];
    }

    return (int) $db->query($query, $params)->fetchColumn();
  }
}