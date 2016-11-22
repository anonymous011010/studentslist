<?php

define('APP_DEBUG', false); // Устанавливает режим дебага приложения
define('ENTRIES_PER_PAGE', 50); // Количество выводимых элементов на одну страницу
define('APP_URL_ADDR', "http://" . filter_var(idn_to_ascii($_SERVER['HTTP_HOST']),FILTER_SANITIZE_URL)); // URL-адрес приложения
define('MAX_VISIBLE_PAGES', 5); // Максимальное количество отображаемых страниц в пагинации (не считая первую и последнюю страницу)

require_once __DIR__ . '/../app/bootstrap.php';
