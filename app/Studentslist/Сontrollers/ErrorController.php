<?php

namespace Studentslist\Controllers;

use Studentslist\Core\Controller;
use Studentslist\Helpers\NavHelper;

/**
 * Контроллер, реализующий отображение ошибок
 *
 */
class ErrorController extends Controller {

    /**
     * Действие вывода ошибки 404
     */
    public function error404() {
        header('HTTP/1.1 404 Not Found');
        $data['host'] = \APP_URL_ADDR;
        $data['title'] = "Error 404 Not Found";
        $navHelper = new NavHelper($data['host']);
        self::renderErrorView('404', $navHelper, $data);
        die();
    }

}
