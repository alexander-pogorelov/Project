<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

//ini_set('default_charset', 'UTF-8');
//ini_set('mbstring.func_overload', 0);
//ini_set('mbstring.internal_encoding', 'UTF-8');



define('ROOT', dirname(__FILE__)); // корневая папка с полным путем
define('FOLDER', basename (__DIR__)); // корневая папка

//echo ROOT."<br>";
//echo FOLDER."<br>";

// Подключаем настройки конфигурации
require_once (ROOT.'/Config/Config.php');
// Подключаем автозагрузчик классов
require_once (ROOT.'/Components/Autoload.php');

//echo 'ROOT: '. ROOT. '<br>';
//echo 'FOLDER: '. FOLDER. '<br>';

///////////////////////////////////////////////////////////////////


/*
$model=new PaginationUri('www.ya.ru', 4, 50, '/page=');
$model->run ();
	echo "<pre>";
	print_r ($model->getPaginationList ());
	echo "</pre>";
exit;
*/

// Добавить вывод в Title категорию товара
// Добавить счетчик товаров по категориям в меню категрий
// Добавить сортировку товаров категории по цене
// Добавить css селекторы списка пагинации, плюс надо ли делать вложенным списком?

// Объект вьюшки - надо ли делать?

session_start();
//echo "Старт роутера<br>";
(new Router)->run();


?>