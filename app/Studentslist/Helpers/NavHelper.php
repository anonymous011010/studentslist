<?php

namespace Studentslist\Helpers;

/**
 * Хелпер навигации
 *
 */
class NavHelper {

    /** @var string URL-адрес приложения */
    private $host;

    /** @var string Тип активной формы (регистрация или редактирование) */
    private $form;

    /** @var string Активный элемент навигации */
    private $activeNav;

    public function __construct($host, $form = '', $activeNav = '') {
        $this->host = $host;
        $this->form = $form;
        $this->activeNav = $activeNav;
    }
    
    /**
     * Метод получения ссылки на форму
     * @return string Ссылка на форму
     */
    public function getFormLink() {
        $path = ($this->form === 'edit') ? '/form/edit' : '/form/register';
        return $this->host . $path;
    }

    /**
     * Метод проверки активности элемента навигации
     * @param string $nav Элемент навигации
     * @return boolean true в случае, если элемент навигации активен, и false если нет
     */
    public function isNavActive($nav) {
        if (isset($this->activeNav) && $nav === $this->activeNav) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Метод получения названия ссылки на форму
     * @return string Название элемента со ссылкой на форму
     */
    public function getFormNavTitle() {
        return (isset($this->form) && $this->form === 'edit') ? 'Редактировать мои данные' : 'Регистрация';
    }

}
