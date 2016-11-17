<?php
use Studentslist\Core\Router;

mb_internal_encoding('UTF-8');
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/ErrorHandler.php';

$handler = new ErrorHandler;
set_exception_handler([$handler, 'handleException']);
set_error_handler([$handler, 'handleError']);
register_shutdown_function([$handler, 'handleFatalError']);

$router = new Router();
$router->run();


