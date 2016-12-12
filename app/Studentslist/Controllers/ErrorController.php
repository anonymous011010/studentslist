<?php

namespace Studentslist\Controllers;

use Studentslist\Core\Controller;
use Studentslist\Core\Auth;
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
        
        $gateway = $this->DbGateway();
        
        $token = (isset($_COOKIE['authToken'])) ? \filter_input(\INPUT_COOKIE, 'authToken', \FILTER_SANITIZE_STRING) : '';
        $auth = new Auth($gateway);

        if ($auth->isRegistred($token)) {
            $form = 'edit';
        } else {
            $form = 'register';
        }

        header('HTTP/1.1 404 Not Found');
        $data['host'] = \APP_URL_ADDR;
        $data['title'] = "Error 404 Not Found";
        $navHelper = new NavHelper($data['host'], $form);
        self::renderErrorView('404', $navHelper, $data);
        die();
    }

}
