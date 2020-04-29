<?php

namespace Studentslist\Models;

use Studentslist\Models\StudentDataGateway;
use Studentslist\Models\Student;

/**
 * Класс, выполняющий валидацию данных.
 */
class StudentValidator {

    private $gateway;

    public function __construct(StudentDataGateway $gateway) {
        $this->gateway = $gateway;
    }
    
    /**
     * Проводит валидацию данных с объекта Student и в случае возникновения ошибок добавляет их в массив.
     * @param Student $student Объект с информацией о студенте
     * @return $array Массив с ошибками
     */
    public function validate(Student $student) {
        $id = $student->id ? $student->id : 0;
        $errors = [];
        $results = ['fname' => $this->checkFname($student->fname),
            'sname' => $this->checkSname($student->sname),
            'gender' => $this->checkGender($student->gender),
            'group' => $this->checkGroup($student->group),
            'byear' => $this->checkByear($student->byear),
            'email' => $this->checkEmail($student->email, $id),
            'examScore' => $this->checkExamScore($student->examScore),
            'local' => $this->checkLocal($student->local)
        ];

        foreach ($results as $key => $value) {
            if ($value !== '') {
                $errors[$key] = $value;
            }
        }

        return $errors;
    }

    /**
     * Валидация E-mail студента
     * @param string $email E-mail студента
     * @param integer $id ID студента
     * @return string пустая строка или строка с ошибкой
     */
    public function checkEmail($email, $id) {
        $regExp = '/^[^@\s]+@[^@\s]+$/ui';
        if (!\preg_match_all($regExp, $email)) {
            return 'Введите корректный E-mail.';
        } elseif ($this->gateway->checkEmailExists($email)) {
            if ($this->gateway->getEmailOwnerId($email) != $id) {
                return 'E-mail уже занят.';
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    /**
     * Валидация имени студента
     * @param string $fname Имя студента
     * @return string пустая строка или строка с ошибкой
     */
    public function checkFname($fname) {
        $regExp = "/^[-'\sа-яё]{1,32}$/ui";
        if (\preg_match_all($regExp, $fname)) {
            return '';
        } else {
            return 'Допускаются только буквы русского алфавита, дефис, апостроф и пробел. От 1 до 32 символов.';
        }
    }

    /**
     * Валидация фамилии студента
     * @param string $sname Фамилия студента
     * @return string пустая строка или строка с ошибкой
     */
    public function checkSname($sname) {
        $regExp = "/^[-'\sа-яё]{1,32}$/ui";
        if (\preg_match_all($regExp, $sname)) {
            return '';
        } else {
            return 'Допускаются только буквы русского алфавита, дефис, апостроф и пробел. От 1 до 32 символов.';
        }
    }

    /**
     * Валилация пола студента
     * @param string $gender Пол студента
     * @return string пустая строка или строка с ошибкой
     */
    public function checkGender($gender) {
        if ($gender === 'male' || $gender === 'female') {
            return '';
        } else {
            return 'Это обязательное поле.';
        }
    }

    /**
     * Валидация группы студента
     * @param string $group Группа студента
     * @return string пустая строка или строка с ошибкой
     */
    public function checkGroup($group) {
        $regExp = '/^[а-яё0-9]{2,5}$/ui';
        if (\preg_match_all($regExp, $group)) {
            return '';
        } else {
            return 'Допускаются только буквы русского алфавита и цифры. От 2 до 5 символов.';
        }
    }

    /**
     * Валидация суммарного бала ЕГЭ студента
     * @param string $examScore Суммарный бал ЕГЭ
     * @return string пустая строка или строка с ошибкой
     */
    public function checkExamScore($examScore) {
        if ($examScore > 0 && $examScore <= 300) {
            return '';
        } else {
            return 'Введите корректный общий бал ЕГЭ.';
        }
    }

    /**
     * Валидация года рождения студента
     * @param integer $byear Год рождения студента
     * @return string пустая строка или строка с ошибкой
     */
    public function checkByear($byear) {
        if ($byear >= 1905 && $byear <= 2004) {
            return '';
        } else {
            return 'Введите корректный год рождения.';
        }
    }

    /**
     * Валидация территориальной принадлежности студента
     * @param boolean $local Территориальная принадлежность студента
     * @return string пустая строка или строка с ошибкой
     */
    public function checkLocal($local) {
        if ($local === 'true' or $local === 'false') {
            return '';
        } else {
            return 'Это обязательное поле.';
        }
    }

}
