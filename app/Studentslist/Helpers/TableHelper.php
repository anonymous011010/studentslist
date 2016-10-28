<?php

namespace Studentslist\Helpers;

/**
 * Хелпер для работы с таблицей
 *
 */
class TableHelper {

    private $host; // URL-адрес приложения
    private $controller; // Текущий контроллер
    private $action; // Текущий action
    private $page; // Текущая страница
    private $order; // Сортировать по
    private $sort; // Порядок сортировки
    private $searchQuery; // Поисковый запрос

    public function __construct($host, $controller, $action, $page, $order, $sort) {
        $this->host = $host;
        $this->controller = $controller;
        $this->action = $action;
        $this->page = $page;
        $this->order = $order;
        $this->sort = $sort;
    }

    public function __set($property, $value) {
        switch ($property) {
            case 'searchQuery':
                $this->searchQuery = $value;
                break;
        }
    }

    /**
     * Метод получения ссылки для колонки
     * @param string $column имя колонки
     * @return string ссылка для колонки
     */
    public function getLinkForColumn($column) {
        $sort = ($column == $this->order) ? $this->changeSort($this->sort) : $this->sort;

        if (!empty($this->searchQuery)) {
            $http_query = \http_build_query(['q' => $this->searchQuery, 'order' => $column, 'sort' => $sort]);
        } else {
            $http_query = \http_build_query(['order' => $column, 'sort' => $sort]);
        }

        $link = $this->host . '/' . $this->controller . '/' . $this->action . '/' . $this->page . '?' . $http_query;
        return $link;
    }

    /**
     * Метод измения порядока вывода на противоположный
     * @param string $oldSort Порядок вывода
     * @return string Противоположный порядок вывода
     */
    public function changeSort($oldSort) {
        if ($oldSort === 'ASC') {
            $sort = 'DESC';
        } else {
            $sort = 'ASC';
        }
        return $sort;
    }

    /**
     * Метод проверки активной колонки
     * @param string $column Имя колонки
     * @return boolean true в случае активной колонки, и false если колонка не активная
     */
    public function isActiveColumn($column) {
        if ($column == $this->order) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Метод получения шеврона
     * @return string Шеврон, перевернутый в противоположную текущему сторону
     */
    public function getChevron() {
        if ($this->sort === 'ASC') {
            $chevron = 'glyphicon-chevron-up';
        } else {
            $chevron = 'glyphicon-chevron-down';
        }
        return $chevron;
    }

}
