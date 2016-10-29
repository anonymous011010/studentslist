<?php

namespace Studentslist\Helpers;

/**
 * Хелпер пагинации
 */
class Paginator {

    private $totalEntries; // Количество всех элементов
    private $entriesPerPage; // Количество элементов на одну страницу
    private $currentPage; // Текущая страница
    private $maxVisiblePages; // Максимальное количество видимых страниц, не должно быть меньше 3х
    private $pagesNum; // Количество страниц
    private $visiblePages; // Количество видимых страниц
    private $startPage; // Начальная страница в цикле пагинации
    private $host; // URL-адрес приложения
    private $controller; // Текущий контроллер
    private $action; // Текущий action
    private $order; // Сортировать по
    private $sort; // Порядок сортировки
    private $searchQuery; // Поисковый запрос

    public function __construct(
    $totalEntries, $entriesPerPage, $currentPage, $maxVisiblePages, $host, $controller, $action, $order, $sort) {
        $this->totalEntries = $totalEntries;
        $this->entriesPerPage = $entriesPerPage;
        $this->currentPage = $currentPage;
        $this->maxVisiblePages = ($maxVisiblePages >= 3) ? $maxVisiblePages : 3;
        $this->host = $host;
        $this->controller = $controller;
        $this->action = $action;
        $this->order = $order;
        $this->sort = $sort;
        $this->pagesNum = $this->countPages();
        $this->countVisiblePages();
    }

    /**
     * Получаем количество всех страниц
     * @return int Количество всех страниц
     */
    private function countPages() {
        return ceil($this->totalEntries / $this->entriesPerPage);
    }

    /**
     * Подсчитывает количество видимых страниц, устанавливает первую страницу в цикле пагинации
     */
    private function countVisiblePages() {
        $this->startPage = $this->currentPage - \intval($this->maxVisiblePages / 2);

        if ($this->startPage <= 2) {
            $this->startPage = 2;
        } else {
            if ($this->pagesNum - $this->startPage < $this->maxVisiblePages) {
                $this->startPage = $this->pagesNum - $this->maxVisiblePages + 1;
            }
        }

        $this->visiblePages = $this->startPage + $this->maxVisiblePages - 1;

        if ($this->visiblePages > $this->pagesNum) {
            $this->visiblePages = $this->pagesNum;
        }
    }

    public function __get($property) {
        switch ($property) {
            case 'currentPage':
                return $this->currentPage;
            case 'pagesNum':
                return $this->pagesNum;
            case 'visiblePages':
                return $this->visiblePages;
            case 'startPage':
                return $this->startPage;
        }
    }

    public function __set($property, $value) {
        switch ($property) {
            case 'searchQuery':
                $this->searchQuery = $value;
                break;
        }
    }

    /**
     * Возвращает ссылку на cледующую страницу
     * @return type Адрес следующей страницы
     */
    public function getLinkForNextPage() {
        $page = $this->currentPage + 1;
        $link = $this->getLinkForPage($page);
        return $link;
    }

    /**
     * Возвращает ссылку на предыдущую страницу
     * @return type Адрес предыдущей страницы
     */
    public function getLinkForPreviousPage() {
        $page = $this->currentPage - 1;
        $link = $this->getLinkForPage($page);
        return $link;
    }

    /**
     * Возвращает ссылку на страницу
     * @param int $page Номер странницы
     * @return string Адрес страницы
     */
    public function getLinkForPage($page) {
        if (!empty($this->searchQuery)) {
            $http_query = \http_build_query(['q' => $this->searchQuery, 'order' => $this->order, 'sort' => $this->sort]);
        } else {
            $http_query = \http_build_query(['order' => $this->order, 'sort' => $this->sort]);
        }
        $link = $this->host . '/' . $this->controller . '/' . $this->action . '/' . $page . '?' . $http_query;
        return $link;
    }

    /**
     * Проверяет нужно ли отображать эллипсис
     * @param string $ellipsis Строка с типом эллипсиса (правый или левый)
     * @return boolean
     */
    public function getEllipsis($ellipsis) {
        switch ($ellipsis) {
            case 'right':
                if ($this->startPage != 2) {
                    return true;
                } else {
                    return false;
                }
            case 'left':
                if ($this->visiblePages < ($this->pagesNum - 1)) {
                    return true;
                } else {
                    return false;
                }
            default :
                return false;
        }
    }

}
