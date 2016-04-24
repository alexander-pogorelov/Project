<?php

class Db {
   
    public static function getConnection() {
        // Устанавливаем соединение
        if (!isset($pdo)) {
            $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=' . ENCODING, USER, PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return $pdo;
    }
}