<?php

namespace Studentslist\Core;

use Studentslist\Models\StudentDataGateway;

/**
 * Класс аутентификации
 *
 */
class Auth {

    private $gateway;

    public function __construct(StudentDataGateway $gateway) {
        $this->gateway = $gateway;
    }

    public function isRegistred($token) {
        if ($this->gateway->checkTokenExists($token) === true) {
            return true;
        } else {
            return false;
        }
    }

    public function logOut() {
        \set_cookie('authToken', '', time() - 3600);
    }

}
