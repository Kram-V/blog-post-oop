<?php

date_default_timezone_set('Asia/Manila');

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers.php";

use Core\App;
use Core\Database;
use Core\ErrorHandler;

set_exception_handler([ErrorHandler::class, 'handleException']); 
set_error_handler([ErrorHandler::class, 'handleError']);

$config = require_once __DIR__ . '/config.php';

App::bind('config', $config);
App::bind('database', new Database($config['database']));


 