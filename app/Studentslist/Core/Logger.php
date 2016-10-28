<?php

namespace Studentslist\Core;

/**
 * Класс логирования
 *
 */
class Logger {

    private static $instance;
    private $logFile;

    private function __construct() {
        $logFile = __DIR__ . '/../../../logs/app_errors.log';
        $this->setLogFile($logFile);
    }

    private function __clone() {}

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
    * Устанавливает или изменяет файл логов
    * @param string $logFile Путь к файлу
    */
    public function setLogFile($logFile) {
        if (!\file_exists($logFile)) {
            throw new \RuntimeException('Log file is not exists');
        } elseif (!\is_writable($logFile)) {
            throw new \RuntimeException('Log file is not writable');
        } else {
            $this->logFile = $logFile;
        }
    }

    /**
    * Передает логеру сообщение об исключении или ошибке
    * @param string $type Тип исключения/ошибки
    * @param string $message Сообщение исключения/ошибки
    * @param string $file Файл в котором было 'выброшено' исключение или произошла ошибка
    * @param string $line Строка в которой было 'выброшено' исключение или произошла ошибка
    */
    public function log($type, $message, $file, $line) {
        $string = date('r',time()) . " {$type}: " . " {$message} " . "In file \"{$file}\" " . "on line {$line}" . "\n";
        $this->write($string);
    }

    private function write($string) {
        \file_put_contents($this->logFile, $string, \FILE_APPEND);
    }

}
