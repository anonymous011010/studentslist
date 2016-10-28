<?php

namespace Studentslist\Core;

/**
 * Маршрутизатор
 */
class Router {

    protected $controller = 'Index';
    protected $method = 'all';
    protected $params = [];

    function __construct() {
        $url = $this->parseUrl();
        if (\class_exists('\Studentslist\\Controllers\\' . \ucfirst($url[0]) . 'Controller')) {
            $this->controller = \ucfirst($url[0]);
            unset($url[0]);
        }

        $controllerName = '\Studentslist\\Controllers\\' . $this->controller . 'Controller';
        $Controller = new $controllerName;

        if (isset($url[1])) {
            if (\method_exists($Controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                $Controller = new \Studentslist\Controllers\ErrorController;
                $this->method = 'error404';
            }
        } else {
            if ($this->controller != 'Index') {
                $Controller = new \Studentslist\Controllers\ErrorController;
                $this->method = 'error404';
            }
        }

        $this->params = $url ? \array_values($url) : [];

        \call_user_func_array([$Controller, $this->method], $this->params);
    }

    private function parseUrl() {
        if ($_SERVER['REQUEST_URI']) {
            list($urlPath, ) = \explode('?', \filter_input(\INPUT_SERVER, 'REQUEST_URI', \FILTER_SANITIZE_URL));
            return $url = \explode('/', \rtrim(\ltrim($urlPath, '/'), '/'));
        }
    }

}
