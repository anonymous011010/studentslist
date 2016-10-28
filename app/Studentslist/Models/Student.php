<?php

namespace Studentslist\Models;

/**
 * Класс для хранения информации об одном студента.
 *
 */
class Student {

    /** @var integer ID студента */
    public $id;

    /** @var string Имя студента */
    public $fname;

    /** @var string Фамилия студента */
    public $sname;

    /** @var string Пол студента */
    public $gender;

    /** @var string Группа студента */
    public $group;

    /** @var integer Год рождения студента */
    public $byear;

    /** @var string E-mail студента */
    public $email;

    /** @var integer Суммарный бал ЕГЭ студента */
    public $examScore;

    /** @var string Территориальная принадлежность студента */
    public $local;

    /** @var string Аутентификационный токен студента */
    private $authToken;

    public function __get($property) {
        switch ($property) {
            case 'authToken':
                return $this->authToken;
        }
    }

    public function __set($property, $value) {
        switch ($property) {
            case 'authToken':
                $this->authToken = $value;
                break;
        }
    }

}
