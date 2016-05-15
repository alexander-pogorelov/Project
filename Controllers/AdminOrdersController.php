<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.05.2016
 * Time: 11:54
 */
class AdminOrdersController extends Admin {

    public static function actionIndex ($pageNumber=1) {
        //echo "Работает AdminOrdersController<br>";
        //echo "Вызван метод actionIndex<br>";
        $pageNumber = intval($pageNumber);
        $pagesAmount = OrderModel::getAdminOrdersPageAmount(); // Получаем общее количество заказов
        if ($pageNumber > $pagesAmount) {
            $pageNumber = $pagesAmount;
        }
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }
        //echo "$pageNumber<br>";
        //exit;
        $ordersList = OrderModel::getAdminOrdersList($pageNumber); // получаем список заказов с учетом пагинации
        //echo "<pre>";
        //print_r ($ordersList);
        //echo "</pre>";

        //echo "$ordersAmount<br>";
        $pagination = new PaginationUri($pageNumber, $pagesAmount, 'page=');
        $pagination->run();


        require_once (ROOT. '/Views/Admin_orders/index.php');
        return true;
    }

    public static function actionDelete ($idOrder) {
        $idOrder = intval($idOrder);
        echo "Работает AdminOrdersController<br>";
        echo "Вызван метод actionDelete<br>";
        if (isset ($_POST['deleteOrderButton'])) {
            /*
            ///////////////////////////////////////////////////////////////////////
            $userData = OrderModel::checkAuthUserByIdOrder($idOrder);
            echo "<pre>";
            print_r ($userData);
            echo "</pre>";
            echo 'Значение элемента массива: '.current($userData).'<br>';
            echo 'Значение ключа массива: '.key($userData).'<br>';

            if (!current($userData)) {
                echo "E-mail отсутствует";
            }
            exit('Останов в AdminOrdersController');
            ///////////////////////////////////////////////////////////////////////
            */

            //echo "Нажата кнопка";
            if (OrderModel::deleteOrderById($idOrder)) {
                header ("Location: /admin/orders"); // Нужен ли полный путь для header????
                exit;
            }else {
                throw new Exception('Ошибка удаления заказа из БД');//генерируем исключение
            }
        }
        require_once (ROOT. '/Views/Admin_orders/delete.php');
        return true;
    }
}