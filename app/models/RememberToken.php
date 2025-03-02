<?php

namespace App\Models;

use Core\App;
use Core\Model;

class RememberToken extends Model {
  public const TOKEN_LIFETIME = 30 * 24 * 60 * 60;

  protected static $table = 'remember_tokens';

  public $id;
  public int $user_id;
  public string $token;
  public string $expires_at;
  public string $created_at;

  public function rotate(): static {
    $this->token = static::generateToken();
    $this->expires_at = static::getExpiryDate();
    return $this->save();
  }

  public static function findValid(string $token): ?static {
    $db = App::get('database');

    $currentTime = date('Y-m-d H:i:s');

    $sql = "SELECT * FROM " . static::$table . " WHERE token = ? and expires_at > ? LIMIT 1";
    $params = [$token, $currentTime];

    $result = $db->fetch($sql, $params, static::class);

    return $result ? $result : null;
  }

  public static function createForUser(int $userId): static {
    return static::create([
      'user_id' => $userId,
      'token' => static::generateToken(),
      'expires_at' => static::getExpiryDate()
    ]);
  }

  public function delete(): void {
    if (!isset($this->id)) {
      return;
    }

    $db = App::get('database');
    $sql = "DELETE FROM " . static::$table . " WHERE id = ?";
    $params = [$this->id];

    $db->query($sql, $params);
  }

  private static function generateToken() {
    return bin2hex(random_bytes(32));
  }

  private static function getExpiryDate(): string {
    return date('Y-m-d H:i:s', time() + static::TOKEN_LIFETIME);
  }
}
