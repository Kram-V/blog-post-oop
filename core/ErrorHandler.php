<?php

namespace Core;

use ErrorException;
use Throwable;

class ErrorHandler {
  public static function handleException(Throwable $exception): void {
    static::logError($exception);

    if (php_sapi_name() === 'cli') {
      static::renderCliError($exception);
    } else {
      static::renderErrorPage($exception);
    }
  }

  public static function handleError($level, $message, $file, $line): void {
    $exception = new ErrorException($message, 0, $level, $file, $line);

    static::handleException($exception);
  }

  private static function renderCliError(Throwable $exception): void {
    $isDebug = App::get('config')['app']['debug'] ?? false;
    $formatMessage = "\033[31m[%s] Error:\033[0m %s: %s in %s on line %d\n";

    if ($isDebug) {
      $errorMessage = static::formatErrorMessage($exception, $formatMessage);
      $trace = $exception->getTraceAsString();
    } else {
      $errorMessage = "\033[31mAn unexpected error occured. Please check error logs for details.\033[0m \n";
      $trace = "";
    }

    fwrite(STDERR, $errorMessage);

    if ($trace) {
      fwrite(STDERR, "\nStack Trace:\n$trace\n");
    }

    exit(1);
  }

  private static function renderErrorPage(Throwable $exception): void {
    $isDebug = App::get('config')['app']['debug'] ?? false;
    $formatMessage = "[%s] Error %s Class: %s in %s on line %d\n";

    if ($isDebug) {
      $errorMessage = static::formatErrorMessage($exception, $formatMessage);
      $trace = $exception->getTraceAsString();
    } else {
      $errorMessage = "An unexpected error occured. Please check error logs for details.\n";
      $trace = "";
    }

    http_response_code(500);
    echo View::render(
      "errors/500", 
      ['errorMessage' => $errorMessage, 'trace' => $trace, 'isDebug' => $isDebug],
      "layout/main"
    );
    exit();
  }

  private static function logError(Throwable $exception): void {
    $formatMessage = "[%s] Error:%s: %s in %s on line %d\n";
    $logMessage = static::formatErrorMessage($exception, $formatMessage);

    error_log($logMessage, 3, __DIR__ . "/../logs/error.log");
  }

  private static function formatErrorMessage(Throwable $exception, string $format): string {
    return sprintf($format, date('Y-m-d H:i:s'), get_class($exception), $exception->getMessage(), $exception->getFile(), $exception->getLine());
  }

} 