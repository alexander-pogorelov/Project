<?php

/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 06.03.2016
 * Time: 17:40
 */
class AdminController extends Admin {

    public function actionIndex () {
        //echo "Работает AdminController<br>";
        //echo "Вызван метод actionIndex<br>";
        require_once (ROOT. '/Views/Admin/index.php');
        // возвращаем истину, чтобы закончить цикл поиска внутренних маршрутов
        return true;
    }

}