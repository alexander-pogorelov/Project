<?php

class Db {
   
    public static function getConnection() {
        // Устанавливаем соединение
		// Заменить на константы!!!!
		//echo 'Хост: '.HOST.'<br>';
		//echo 'База: '.DATABASE.'<br>';
		$pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE. ';charset=' . ENCODING, USER, PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}