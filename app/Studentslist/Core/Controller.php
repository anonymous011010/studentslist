<?php

namespace Studentslist\Core;

use Studentslist\Models\StudentDataGateway;
use Studentslist\Helpers\NavHelper;
use Studentslist\Helpers\TableHelper;
use Studentslist\Helpers\Paginator;

/**
 * Родительский контроллер
 */
class Controller {

    /**
     * Метод получения объекта класса StudentDataGateway
     * @return StudentDataGateway
     */
    public static function DbGateway() {
        $DB = Database::getInstance();
        return new StudentDataGateway($DB->getPDO());
    }

    /**
     * Метод рендеринга View
     * @param string $view Название View
     * @param NavHelper $navHelper Хелпер, объект класса NavHelper
     * @param array $data Массив с данными для View
     */
    public static function renderView($view, NavHelper $navHelper, $data = []) {
        ob_start();
        require_once __DIR__ . '/../Views/' . $view . '.php';
        ob_get_flush();
        exit(0);
    }

    /**
     * Метод рендеринга View с таблицей
     * @param string $view Название View
     * @param NavHelper $navHelper Хелпер, объект класса NavHelper
     * @param TableHelper $tableHelper Хелпер, объект класса TableHelper
     * @param Paginator $paginator Хелпер, объект класса Paginator
     * @param array $data Массив с данными для View
     */
    public static function renderViewTable($view, NavHelper $navHelper, TableHelper $tableHelper, Paginator $paginator, $data = []) {
        ob_start();
        require_once __DIR__ . '/../Views/' . $view . '.php';
        ob_get_flush();
        exit(0);
    }

    /**
     * Метод рендеринга View страницы ошшибки
     * @param string $view Название View
     * @param NavHelper $navHelper Хелпер, объект класса NavHelper
     * @param array $data Массив с данными для View
     */
    public static function renderErrorView($view, NavHelper $navHelper = null, $data = []) {
        ob_start();
        require_once __DIR__ . '/../Views/errors/' . $view . '.php';
        ob_get_flush();
        exit(0);
    }

}
