<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 06.03.2016
 * Time: 11:05
 */

spl_autoload_register(function ($className) {
    $arrayFolder = array(
        "Components/",
        "Controllers/",
        "Models/",
        "Views/"
    );
    foreach ($arrayFolder as $folder) {
        $filename = $folder . $className . ".php";
        if (is_readable($filename)) { // добавить else для ошибок
            require_once $filename;
            return;
        }
    }
});







