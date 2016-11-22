<?php

namespace Studentslist\Controllers;

use Studentslist\Core\Controller;
use Studentslist\Core\Auth;
use Studentslist\Core\Logger;
use Studentslist\Models\StudentValidator;
use Studentslist\Models\Student;
use Studentslist\Helpers\NavHelper;
use Studentslist\Helpers\TokenHelper;

/**
 *  Контроллер, реализующий регистрацию студентов и редактирование информации зарегистрированных студента
 *
 */
class FormController extends Controller {

    /**
     * Действие редактирования информации зарегистрированного студента
     */
    public function edit() {

        $tokenHelper = new TokenHelper;
        $gateway = $this->DbGateway();
        $token = (isset($_COOKIE['authToken'])) ? \filter_input(\INPUT_COOKIE, 'authToken', \FILTER_SANITIZE_STRING) : '';
        $auth = new Auth($gateway);

        if ($auth->isRegistred($token)) {
            $data['student'] = $gateway->getStudentByToken($token);
        } else {
            header('Location: ' . \APP_URL_ADDR . '/form/register');
            return;
        }

        $data['host'] = \APP_URL_ADDR;
        $data['title'] = "Редактирование";
        $data['legend'] = "Редактирование информации о студенте";
        $data['AntiCSRF-TOKEN'] = $tokenHelper->createAntiCsrfToken();
        \setcookie('AntiCSRF-TOKEN', $data['AntiCSRF-TOKEN'], 0, '/');

        $navHelper = new NavHelper($data['host'], 'edit', 'form');

        if (!empty($_POST['fname']) && !empty($_POST['sname'])) {
            $validator = new StudentValidator($gateway);

            $student = new Student;

            $student->id = $gateway->getIdByToken($token);
            $student->fname = \filter_input(\INPUT_POST, 'fname');
            $student->sname = \filter_input(\INPUT_POST, 'sname');
            $student->gender = \filter_input(\INPUT_POST, 'gender');
            $student->group = \filter_input(\INPUT_POST, 'group');
            $student->byear = (int) \filter_input(\INPUT_POST, 'byear');
            $student->email = \filter_input(\INPUT_POST, 'email');
            $student->examScore = (int) \filter_input(\INPUT_POST, 'examScore');
            $student->local = \filter_input(\INPUT_POST, 'local');

            $data['errors'] = $validator->validate($student);

            if (!isset($_COOKIE['AntiCSRF-TOKEN']) || !isset($_POST['AntiCSRF-TOKEN']) ||
                    \filter_input(\INPUT_COOKIE, 'AntiCSRF-TOKEN') !== \filter_input(\INPUT_POST, 'AntiCSRF-TOKEN')) {
                $data['CSRF-Error'] = true;
                $this->renderView('form', $navHelper, $data);
                return;
            }

            if (empty($data['errors'])) {
                try {
                    $gateway->updateStudent($gateway->convertStudentToArray($student, 'update'));
                    $data['title'] = "Измение данных прошло успешно";
                    //header("Refresh:5; url=" . \APP_URL_ADDR, true, 303);
                    $navHelper = new NavHelper($data['host'], 'edit');
                    $this->renderView('success', $navHelper, $data);
                    return;
                } catch (\PDOException $ex) {
                    $data['fail']['message'] = "Не удалось изменить данные, пожалуйста, повторите попытку снова.";
                    $logger = Logger::getInstance();
                    $logger->log(\get_class($ex), $ex->getMessage(), $ex->getFile(), $ex->getLine());
                    $this->renderView('form', $navHelper, $data);
                    return;
                }
            }
        }
        $this->renderView('form', $navHelper, $data);
    }

    /**
     * Действие регистрации нового студента
     */
    public function register() {

        $tokenHelper = new TokenHelper;
        $gateway = $this->DbGateway();
        $token = (isset($_COOKIE['authToken'])) ? \filter_input(\INPUT_COOKIE, 'authToken', \FILTER_SANITIZE_STRING) : '';
        $auth = new Auth($gateway);

        if (!$auth->isRegistred($token)) {
            $token = $tokenHelper->createAuthToken();
        } else {
            header('Location: ' . \APP_URL_ADDR . '/form/edit');
            return;
        }

        $data['host'] = \APP_URL_ADDR;
        $data['title'] = "Регистрация";
        $data['legend'] = "Регистрация нового студента";
        $data['AntiCSRF-TOKEN'] = $tokenHelper->createAntiCsrfToken();
        \setcookie('AntiCSRF-TOKEN', $data['AntiCSRF-TOKEN'], 0, '/');

        $navHelper = new NavHelper($data['host'], 'register', 'form');

        if (!empty($_POST['fname']) && !empty($_POST['sname'])) {

            $validator = new StudentValidator($gateway);
            $student = new Student();
            $student->fname = \filter_input(\INPUT_POST, 'fname');
            $student->sname = \filter_input(\INPUT_POST, 'sname');
            $student->gender = \filter_input(\INPUT_POST, 'gender');
            $student->group = \filter_input(\INPUT_POST, 'group');
            $student->byear = (int) \filter_input(\INPUT_POST, 'byear');
            $student->email = \filter_input(\INPUT_POST, 'email');
            $student->examScore = (int) \filter_input(\INPUT_POST, 'examScore');
            $student->local = \filter_input(\INPUT_POST, 'local');
            $student->authToken = $token;

            $data['errors'] = $validator->validate($student);

            $data['student'] = \get_object_vars($student);

            if (!isset($_COOKIE['AntiCSRF-TOKEN']) || !isset($_POST['AntiCSRF-TOKEN']) ||
                    \filter_input(\INPUT_COOKIE, 'AntiCSRF-TOKEN') !== \filter_input(\INPUT_POST, 'AntiCSRF-TOKEN')) {
                $data['CSRF-Error'] = true;
                $this->renderView('form', $navHelper, $data);
                return;
            }

            if (empty($data['errors'])) {
                try {
                    $gateway->addStudent($gateway->convertStudentToArray($student, 'insert'));
                    \setcookie('authToken', $token, time() + 60 * 60 * 24 * 30, '/');
                    $data['title'] = "Регистрация прошла успешно";
                    $navHelper = new NavHelper($data['host'], 'edit');
                    //header("Refresh:5; url=" . \APP_URL_ADDR, true, 303);
                    $this->renderView('success', $navHelper, $data);
                    return;
                } catch (\PDOException $ex) {
                    $data['fail']['message'] = "Регистрация не удалась, пожалуйста, повторите попытку снова.";
                    $logger = Logger::getInstance();
                    $logger->log(\get_class($ex), $ex->getMessage(), $ex->getFile(), $ex->getLine());
                    $this->renderView('form', $navHelper, $data);
                    return;
                }
            }
        }

        $this->renderView('form', $navHelper, $data);
    }

}
