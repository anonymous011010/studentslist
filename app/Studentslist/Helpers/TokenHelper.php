<?php
namespace Studentslist\Helpers;

/**
 * Хелпер для создания аутентификационных и анти-CSRF токенов
 */
class TokenHelper {

    /**
     * Создаем аутентификационный токен
     * @return string Аутентификационный токен
     */
    public function createAuthToken() {
        return \preg_replace('/=|\+|\//', '_', \base64_encode(\openssl_random_pseudo_bytes(45)));
    }
    
    /**
    * Создаем Анти-CSRF токен
    * @return string Анти-CSRF токен
    */
    public function createAntiCsrfToken() {
       return \preg_replace('/=|\+|\//', '_', \base64_encode(\openssl_random_pseudo_bytes(45)));
    }
}
