<?php

namespace Studentslist\Controllers;

use Studentslist\Core\Controller;
use Studentslist\Core\Auth;
use Studentslist\Helpers\NavHelper;
use Studentslist\Helpers\TableHelper;
use Studentslist\Helpers\Paginator;

/**
 * Контроллер, реализующий список всех студентов и поиск студентов
 *
 */
class IndexController extends Controller {

    /**
     * Действие вывода списка всех студентов
     * @param string $page Запрашиваемая страница
     */
    public function all($page = "") {

        $page = (int) \filter_var($page, \FILTER_SANITIZE_NUMBER_INT);
        $page = ((!$page) || ($page < 1)) ? 1 : $page;

        $gateway = $this->DbGateway();

        $token = (isset($_COOKIE['authToken'])) ? \filter_input(\INPUT_COOKIE, 'authToken', \FILTER_SANITIZE_STRING) : '';
        $auth = new Auth($gateway);

        if ($auth->isRegistred($token)) {
            $form = 'edit';
        } else {
            $form = 'register';
        }
        
        $limit = \ENTRIES_PER_PAGE;

        $studentsNum = $gateway->countStudents();
        $offset = ($page - 1) * $limit;

        if ($offset > $studentsNum) {
            $ErrorController = new \Studentslist\Controllers\ErrorController;
            $ErrorController->error404();
        }

        $order = (isset($_GET['order'])) ? $gateway->getOrder(\filter_input(\INPUT_GET, 'order')) : 'examScore';
        $sort = (isset($_GET['sort'])) ? $gateway->getSort(\filter_input(\INPUT_GET, 'sort')) : 'DESC';

        $data = [
            'studentsNum' => $studentsNum,
            'students' => $gateway->getAllStudents($order, $sort, $offset, $limit),
            'title' => "Список студентов",
            'host' => \APP_URL_ADDR];

        $navHelper = new NavHelper($data['host'], $form, 'index');
        $tableHelper = new TableHelper($data['host'], 'index', 'all', $page, $order, $sort);
        $paginator = new Paginator($data['studentsNum'], $limit, $page, \MAX_VISIBLE_PAGES, $data['host'], 'index', 'all', $order, $sort);
        $this->renderViewTable('index', $navHelper, $tableHelper, $paginator, $data);
    }

    /**
     * Действие поиска студентов
     * @param string $page Запрашиваемая страница
     */
    public function search($page = '') {

        $data['host'] = \APP_URL_ADDR;
        $data['title'] = "Поиск студентов";
        $gateway = $this->DbGateway();
               
        $token = (isset($_COOKIE['authToken'])) ? \filter_input(\INPUT_COOKIE, 'authToken', \FILTER_SANITIZE_STRING) : '';
        $auth = new Auth($gateway);

        if ($auth->isRegistred($token)) {
            $form = 'edit';
        } else {
            $form = 'register';
        }

        $navHelper = new NavHelper($data['host'], $form);

        if (isset($_GET['q']) && !empty($_GET['q'])) {

            $page = (int) \filter_var($page, \FILTER_SANITIZE_NUMBER_INT);
            $page = ((!$page) || ($page < 1)) ? 1 : $page;

            $search = $gateway->fixSearchQuery(\strval(\trim(\filter_input(\INPUT_GET, 'q'))));

            $order = (isset($_GET['order'])) ? $gateway->getOrder($_GET['order']) : 'examScore';
            $sort = (isset($_GET['sort'])) ? $gateway->getSort($_GET['sort']) : 'DESC';

            $limit = \ENTRIES_PER_PAGE;

            $offset = ($page - 1) * $limit;
            $studentsBySearchNum = $gateway->countStudentsBySearch($search);

            if ($offset > $studentsBySearchNum) {
                $ErrorController = new \Studentslist\Controllers\ErrorController;
                $ErrorController->error404();
            }

            $data['students'] = $gateway->findStudents($search, $order, $sort, $offset, $limit);

            $data['search'] = $search;

            $tableHelper = new TableHelper($data['host'], 'index', 'search', $page, $order, $sort);
            $paginator = new Paginator($studentsBySearchNum, $limit, $page, \MAX_VISIBLE_PAGES, $data['host'], 'index', 'search', $order, $sort);

            $tableHelper->searchQuery = $search;
            $paginator->searchQuery = $search;

            $this->renderViewTable('results', $navHelper, $tableHelper, $paginator, $data);
        } else {
            $this->renderView('results', $navHelper, $data);
        }
    }

}
