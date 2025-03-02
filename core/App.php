<?php

namespace Core;

use Exception;

class App {
  protected static array $container = [];

  public static function bind(string $key, mixed $value): void {
    static::$container[$key] = $value;
  }

  public static function get(string $key): mixed {
    if (!array_key_exists($key, static::$container)) {
      throw new Exception("No {$key} exists!");
    }

    return static::$container[$key];
  }
}