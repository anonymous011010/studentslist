<?php

use Studentslist\Core\Logger;

class Handler {

    private $logger;
    private $errorsArray;

    public function __construct() {
        try {
            $this->logger = Logger::getInstance();
        } catch (Exception $e) {
            if (APP_DEBUG) {
                echo $e->__toString();
            }
        }
        $this->errorsArray = $this->getErrorsArray();
    }

    public function exceptionHandler($exception) {
        $this->logger->log(get_class($exception), $exception->getMessage(), $exception->getFile(), $exception->getLine());

        if (APP_DEBUG) {
            $this->show(get_class($exception), $exception->getMessage(), $exception->getFile(), $exception->getLine());
        } else {
            $this->shutdownApp();
        }
    }

    public function errorHandler($errno, $errstr, $errfile, $errline) {

        $errors = $this->errorsArray;

        $errtype = (array_key_exists($errno, $errors)) ? $errors[$errno] : $errno;

        $this->logger->log($errtype, $errstr, $errfile, $errline);

        if (APP_DEBUG) {
            $this->show($errtype, $errstr, $errfile, $errline);
        }
    }

    public function fatalErrorHandler() {

        if (error_get_last() !== null) {
            $error = error_get_last();

            if (in_array($error['type'], [E_ERROR, E_PARSE, E_COMPILE_ERROR, E_CORE_ERROR])) {
                $this->shutdownApp();
            }

            $this->errorHandler($error['type'], $error['message'], $error['file'], $error['line']);
        }
    }

    public function show($type, $message, $file, $line) {
        echo " {$type}: " . " {$message} " . "In file \"{$file}\" " . "on line {$line}" . "\n";
    }

    private function shutdownApp() {
        ob_end_clean();
        header('HTTP/1.1 500 Internal Server Error');
        include __DIR__ . '/Studentslist/Views/errors/500.php';
        die();
    }

    private function getErrorsArray() {
        $errors = [
            E_ERROR => 'E_ERROR',
            E_WARNING => 'E_WARNING',
            E_PARSE => 'E_PARSE',
            E_NOTICE => 'E_NOTICE',
            E_CORE_ERROR => 'E_CORE_ERROR',
            E_CORE_WARNING => 'E_CORE_WARNING',
            E_COMPILE_ERROR => 'E_COMPILE_ERROR',
            E_COMPILE_WARNING => 'E_COMPILE_WARNING',
            E_USER_ERROR => 'E_USER_ERROR',
            E_USER_WARNING => 'E_USER_WARNING',
            E_USER_NOTICE => 'E_USER_NOTICE',
            E_STRICT => 'E_STRICT',
            E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
            E_DEPRECATED => 'E_DEPRECATED',
            E_USER_DEPRECATED => 'E_USER_DEPRECATED'];
        return $errors;
    }

}
