<?php

namespace Studentslist\Models;

/**
 * Класс, который отвечает за работу с БД.
 */
class StudentDataGateway {

    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Метод для подсчитывания количества всех студентов
     * @return integer Количество всех студентов
     */
    public function countStudents() {
        $prepared = $this->pdo->prepare("SELECT COUNT(*) FROM `students`");
        $prepared->execute();
        return (int) $prepared->fetchColumn();
    }

    /**
     * Метод для получения всех студентов
     * @param string $order Сортировка по значению
     * @param string $sort Сортировать по возрастанию или убиванию
     * @param integer $offset Количество пропущенных записей
     * @param integer $limit Ограничение количества выбранных записей за один запрос
     * @return array Список студентов
     */
    public function getAllStudents($order, $sort, $offset = 0, $limit = 5) {
        $prepared = $this->pdo->prepare("SELECT"
                . " `fname`,"
                . " `sname`,"
                . " `group`,"
                . " `examScore`"
                . " FROM `students`"
                . " ORDER BY `$order` $sort, `id` DESC"
                . " LIMIT $limit OFFSET $offset");
        $prepared->execute();
        $allStudents = $prepared->fetchAll(\PDO::FETCH_ASSOC);
        return $allStudents;
    }

    /**
     * Возращает количество всех студентов по заданому поисковому запросу
     * @param string $search Поисковый запрос
     * @return integer Количество всех студентов за заданым поисковым запросом
     */
    public function countStudentsBySearch($search) {
        $prepared = $this->pdo->prepare("SELECT COUNT(*) FROM `students`"
                . " WHERE CONCAT(`fname`,`sname`,`group`,`examScore`) LIKE :search");
        $prepared->bindValue(":search", "%$search%");
        $prepared->execute();
        return (int) $prepared->fetchColumn();
    }

    /**
     * Метод для получения cтудентов, которые соотвествуют запросу
     * @param string $search Строка с запросом
     * @param string $order Сортировать по значению
     * @param string $sort Сортировать по возрастанию или убиванию
     * @param integer $offset Количество пропущенных записей
     * @param integer $limit Ограничение количества выбранных записей за один запрос
     * @return array Список студентов, соответствующих запросу
     */
    public function findStudents($search, $order, $sort, $offset = 0, $limit = 5) {
        $prepared = $this->pdo->prepare("SELECT"
                . " `fname`,"
                . " `sname`,"
                . " `group`,"
                . " `examScore`"
                . " FROM `students`"
                . " WHERE CONCAT(`fname`,`sname`,`group`,`examScore`) LIKE :search"
                . " ORDER BY `$order` $sort, `id` DESC"
                . " LIMIT $limit OFFSET $offset");
        $prepared->bindValue(":search", "%$search%");
        $prepared->execute();
        $studentsByName = $prepared->fetchAll(\PDO::FETCH_ASSOC);
        return $studentsByName;
    }

    /**
     * Метод добавления студента
     * @param array $student Массив с данными студента
     */
    public function addStudent(array $student) {
        $prepared = $this->pdo->prepare("INSERT INTO `students` ("
                . " `fname`,"
                . " `sname`,"
                . " `gender`,"
                . " `group`,"
                . " `byear`,"
                . " `email`,"
                . " `examScore`,"
                . " `local`,"
                . " `authToken`)"
                . " VALUES(:fname,:sname,:gender,:group,:byear,:email,:examScore,:local,:authToken)");
        $prepared->execute($student);
    }

    /**
     * Метод обновления информации о студенте
     * @param array $student Массив с данными студента
     */
    public function updateStudent(array $student) {
        $prepared = $this->pdo->prepare("UPDATE `students` SET"
                . " `fname` = :fname,"
                . " `sname` = :sname,"
                . " `gender` = :gender,"
                . " `group` = :group,"
                . " `byear` = :byear,"
                . " `email` = :email,"
                . " `examScore` = :examScore,"
                . " `local` = :local"
                . " WHERE `id` = :id");
        $prepared->execute($student);
    }

    /**
     * Метод удаления студена
     * @param int $id ID студента
     */
    public function deleteStudent($id) {
        $prepared = $this->pdo->prepare("DELETE FROM `students` WHERE `id` = :id");
        $prepared->bindValue(":id", $id);
        $prepared->execute();
    }

    /**
     * Метод проверки существования E-mail адреса в базе данных
     * @param string $email Проверяемый E-mail адрес
     * @return boolean Возвращает true, если E-mail существует в базе данных, и false если нет
     */
    public function checkEmailExists($email) {
        $prepared = $this->pdo->prepare("SELECT EXISTS(SELECT `id` FROM `students` WHERE `email`=:email LIMIT 1)");
        $prepared->bindValue(":email", $email);
        $prepared->execute();
        $exists = $prepared->fetchColumn();
        if ((int) $exists === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Метод поиска владельца E-mail адреса в базе данных
     * @param string $email E-mail студента
     * @return integer id студента с данным E-mail
     */
    public function getEmailOwnerId($email) {
        $prepared = $this->pdo->prepare("SELECT `id` FROM `students` WHERE `email`=:email LIMIT 1");
        $prepared->bindValue(":email", $email);
        $prepared->execute();
        return (int) $prepared->fetchColumn();
    }

    /**
     * Метод проверки существования авторизационного токена в базе данных
     * @param string $token Авторизационный токен
     * @return boolean Возвращает true, если токен существует в базе данных, и false если нет
     */
    public function checkTokenExists($token) {
        $prepared = $this->pdo->prepare("SELECT EXISTS(SELECT `id` FROM `students` WHERE `authToken`=:authToken LIMIT 1)");
        $prepared->bindValue(":authToken", $token);
        $prepared->execute();
        $exists = $prepared->fetchColumn();
        if ((int) $exists === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Метод получения ID по токену
     * @param string $token Авторизационный токен
     * @return integer ID владельца токена
     */
    public function getIdByToken($token) {
        $prepared = $this->pdo->prepare("SELECT `id` FROM `students` WHERE `authToken`=:authToken LIMIT 1");
        $prepared->bindValue(":authToken", $token);
        $prepared->execute();
        return (int) $prepared->fetchColumn();
    }

    /**
     * Возвращает студента с определенным токеном
     * @param string $token Авторизационный токен
     * @return array Студент по заданому токену
     */
    public function getStudentByToken($token) {
        $prepared = $this->pdo->prepare("SELECT"
                . " `fname`,"
                . " `sname`,"
                . " `gender`,"
                . " `group`,"
                . " `byear`,"
                . " `email`,"
                . " `examScore`,"
                . " `local` FROM `students` WHERE `authToken` = :authToken");
        $prepared->bindValue(":authToken", $token);
        $prepared->execute();
        $studentByToken = $prepared->fetch(\PDO::FETCH_ASSOC);
        return $studentByToken;
    }

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
