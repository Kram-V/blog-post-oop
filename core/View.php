<?php

namespace Core;

use RuntimeException;

class View {
  protected static $globals = [];

  public static function share(string $key, mixed $value): void {
    static::$globals[$key] = $value; 
  }

  public static function render(string $template, array $data = [], ?string $layout = null): string {
    $data = [...$data, ...static::$globals];
    $content = static::renderTemplate($template, $data);

    return static::renderLayout($layout, $data, $content);
  }

  protected static function renderTemplate(string $template, array $data): string {
    extract($data);

    $path = dirname(__DIR__) . "/app/views/{$template}.php";

    if (!file_exists($path)) {
      throw new RuntimeException("Error: Template file not found: $path");
    }

    ob_start();
    require $path;

    return ob_get_clean();
  }

  protected static function renderLayout(?string $template, array $data, string $content): string {
    if ($template === null) {
      return $content;
    }

    extract([...$data, 'content' => $content]);

    $path = dirname(__DIR__) . "/app/views/{$template}.php";

    if (!file_exists($path)) {
      throw new RuntimeException("Error: Layout file not found: $path");
    }

    ob_start();
    require $path;

    return ob_get_clean();
  }
}