<?php

/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 10.03.2016
 * Time: 21:39
 */
class AdminBrandController extends Admin {

    public function actionIndex () {
        //echo "Работает AdminBrandController<br>";
        //echo "Вызван метод actionIndex<br>";
        $brandList = BrandModel::getAdminBrandList();
        require_once (ROOT. '/Views/Admin_brand/index.php');
        return true;
    }

    public function actionDelete ($brandId) {
        //echo "Работает AdminBrandController<br>";
        //echo "Вызван метод actionIndex<br>";
        if (isset ($_POST['delete'])) {
            //echo "Нажата кнопка";
            if (BrandModel::deleteBrandById($brandId)) {
                header ("Location: /admin/brand"); // Нужен ли полный путь для header????
                exit;
            }else {
                throw new Exception('Ошибка удаления брэнда из базы');//генерируем исключение
            }
        }
        require_once (ROOT. '/Views/Admin_brand/delete.php');
        return true;
    }

    public function actionCreate () {
        //echo "Работает AdminBrandController<br>";
        //echo "Вызван метод actionCreate<br>";

        $data['error'] = array();
        $data['value'] = array();
        $data['newBrand'] = array();
        if (isset($_POST['create'])) {
            //echo "Нажата кнопка добавления товара<br>";
            $data = BrandModel::formCreateBrand();
            if (count($data['error']) == 0) {
                echo "Ошибок нету!!!<br>";
                //создаем запрос на добавление данных
                if (BrandModel::createNewBrand($data['newBrand'])) {
                    header ("Location: /admin/brand"); // Нужен ли полный путь для header????
                    exit;
                }else {
                    throw new Exception('Ошибка добавления нового брэнда в базу данных');//генерируем исключение
                }
            }
        }
        require_once (ROOT. '/Views/Admin_brand/create.php');
        return true;
    }

    public function actionUpdate ($brandId) {
        //echo "Работает AdminBrandController<br>";
        //echo "Вызван метод actionUpdate<br>";

        $brandItem = BrandModel::getBrandItemById($brandId);
        //var_dump($brandItem);

        if (isset ($_POST['update'])) {
            //echo "Нажата кнопка";
            if (BrandModel::updateBrandById($brandId)) {
                header ("Location: /admin/brand"); // Нужен ли полный путь для header????
                exit;
            }else {
                throw new Exception('Ошибка обновления брэнда из базы');//генерируем исключение
            }
        }

        require_once (ROOT. '/Views/Admin_brand/update.php');
        return true;
    }


}