<?php

namespace Studentslist\Helpers;

use Studentslist\Models\Student;

/**
 * Хелпер для помощи в работе с базой данных
 */
class DBHelper {

    /**
     * Исправляет поисковый запрос
     * @param string $query Поисковый запрос
     * @return string Исправленный поисковый запрос
     */
    public function fixSearchQuery($query) {
        return \preg_replace('/[\s]+/u', '%', $query);
    }

    /**
     * Возвращает безопасное значение ORDER BY
     * @param string $order имя колонки
     * @return string Значение колонки в ORDER BY
     */
    public function getOrder($order) {
        switch ($order) {
            case 'fname':
                $order = 'fname';
                break;
            case 'sname':
                $order = 'sname';
                break;
            case 'group':
                $order = 'group';
                break;
            case 'examScore':
                $order = 'examScore';
                break;
            default :
                $order = 'examScore';
        }
        return $order;
    }

    /**
     * Возвращает безопасное значени порядка сортирования
     * @param string $sort DESC или ASC
     * @return string DESC или ASC в зависимости от переданных параметров
     */
    public function getSort($sort) {
        switch ($sort) {
            case 'ASC':
                $sort = 'ASC';
                break;
            case 'DESC':
                $sort = 'DESC';
                break;
            default :
                $sort = 'DESC';
        }
        return $sort;
    }

    /**
     * Конвертирует объект класса Student в ассоциативный массив
     * Последний элемент массива зависит от типа действия
     * @param Student $student Объект класса Student
     * @param string $action Тип действия
     * @return array Массив с информацией о студенте
     */
    public function convertStudentToArray(Student $student, $action) {
        $array = [];
        $array['fname'] = $student->fname;
        $array['sname'] = $student->sname;
        $array['gender'] = $student->gender;
        $array['group'] = $student->group;
        $array['byear'] = $student->byear;
        $array['email'] = $student->email;
        $array['examScore'] = $student->examScore;
        $array['local'] = $student->local;

        if ($action == 'update' && !empty($student->id)) {
            $array['id'] = $student->id;
        } elseif ($action == 'insert') {
            $array['authToken'] = $student->authToken;
        }

        return $array;
    }

}
