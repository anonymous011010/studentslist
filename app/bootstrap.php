<?php

mb_internal_encoding('UTF-8');
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Handler.php';

use Studentslist\Core\Router;

define('APP_DEBUG', false); // Устанавливает режим дебага приложения
define('ENTRIES_PER_PAGE', 50); // Количество выводимых элементов на одну страницу
define('APP_URL_ADDR', "http://" . filter_input(INPUT_SERVER, 'HTTP_HOST')); // URL-адрес приложения
define('MAX_VISIBLE_PAGES', 5); // Максимальное количество отображаемых страниц в пагинации (не считая первую и последнюю страницу)

$handler = new Handler;
set_exception_handler([$handler, 'exceptionHandler']);
set_error_handler([$handler, 'errorHandler']);
register_shutdown_function([$handler, 'fatalErrorHandler']);

$router = new Router();


