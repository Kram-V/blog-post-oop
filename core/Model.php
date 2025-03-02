<?php

namespace Core;

abstract class Model { 
  protected static $table;
  public $id;

  public static function all(?string $search = null, ?int $limit = null, ?int $page = null): array {
    $db = App::get('database');

    $query = 'SELECT * FROM ' . static::$table;
    $params = [];

    if ($search) {
      $query .= ' WHERE title LIKE ?'; 
      $params = ["%{$search}%"];
    }

    $query .= ' ORDER BY created_at DESC';

    if ($limit) {
      $query .= ' LIMIT ?';
      $params[] = $limit;
    }

    if ($page && $limit) {
      $offset = ($page - 1) * $limit;
      $query .= " OFFSET ?";
      $params[] = $offset;
    }

    return $db->fetchAll($query, $params, static::class);
  }

  public static function find(mixed $id): static|bool|null {   
    $db = App::get('database');

    return $db->fetch('SELECT * FROM ' . static::$table . ' WHERE id = ?', [$id], static::class);
  }

  public static function create(array $data): static|\Closure {
    $db = App::get('database');

    $columns = implode(', ', array_keys($data));

    $placeholders = implode(', ', array_fill(0, count($data), '?'));

    $sql = "INSERT INTO " . static::$table . " ({$columns}) VALUES ({$placeholders})";
    $db->query($sql, array_values($data));

    return static::find($db->lastInsertId());
  }

  public function delete(): void {
    if (!isset($this->id)) {
      return;
    }

    $db = App::get('database');
    $sql = 'DELETE FROM ' . static::$table . ' Where id = ?';
    $params[] = $this->id; 

    $db->query($sql, $params);
  }

  public function save(): static {
    $db = App::get('database');

    $data = get_object_vars($this);

    if (!isset($this->id)) {
      unset($data['id']);

      return static::create($data);
    }

    unset($data['id']);

    $setParts = array_map(function ($column) {
      return "{$column} = ?";
    }, array_keys($data));

    $sql = "UPDATE " . static::$table . " SET " . implode(', ' , $setParts) . "WHERE id = ?";

    $params = array_values($data);
    $params[] = $this->id;

    $db->query($sql, $params);

    return $this;
  }
}