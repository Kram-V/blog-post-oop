<?php
declare (strict_types = 1);
session_start();

require_once __DIR__ . "/../bootstrap.php";

use Core\Router;

$router = new Router();

require_once __DIR__ . "/../routes.php"; 

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

$result = $router->dispatch($uri, $method);

while ($result instanceof \Closure) {
  $result = $result();
}

echo $result;