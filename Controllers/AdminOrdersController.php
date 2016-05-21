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
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }
        $pagesAmount = OrderModel::getAdminOrdersPageAmount(); // Получаем общее количество заказов
        if ($pageNumber > $pagesAmount) {
            $pageNumber = $pagesAmount;
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
        //echo "Работает AdminOrdersController<br>";
        //echo "Вызван метод actionDelete<br>";
        if (isset ($_POST['deleteOrderButton'])) {
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

    public static function actionView ($idOrder) {
        //echo "Работает AdminOrdersController<br>";
        //echo "Вызван метод actionView<br>";
        $idOrder = intval($idOrder);
        //echo 'ID заказа: '.$idOrder.'<br>';
        $orderAndUserInfo = OrderModel::getUserAndOrderInfoByIdOrder($idOrder);
        $productsInOrder = OrderModel::getProductsByIdOrder($idOrder);
        //echo "<pre>";
        //print_r ($orderAndUserInfo);
        //echo "</pre>";
        require_once (ROOT. '/Views/Admin_orders/view.php');
        return true;
    }

    public static function actionUpdate ($idOrder) {
        //echo "Работает AdminOrdersController<br>";
        //echo "Вызван метод actionUpdate<br>";
        //echo 'ID заказа: '.$idOrder.'<br>';
        $idOrder = intval($idOrder);
        $orderAndUserInfo = OrderModel::getUserAndOrderInfoByIdOrder($idOrder);
        $productsInOrder = OrderModel::getProductsByIdOrder($idOrder);
        $orderStatusList = OrderModel::getOrderStatusList();

        if (isset ($_POST['orderUpdate'])) {
            //echo "Нажата кнопка";
            //$temp = OrderModel::updateOrderAndUserInfoByIdOrder($idOrder);
            //echo "<pre>";
            //print_r ($temp);
            //echo "</pre>";
            //echo '<br>ID User: '.OrderModel::getIdUserByIdOrder($idOrder);
            //exit;

            if (OrderModel::updateOrderAndUserInfoByIdOrder($idOrder)) {
                header ('Location: /admin/orders/view/'.$idOrder); // Нужен ли полный путь для header????
                exit;
            }else {
                throw new Exception('Ошибка обновления заказа в БД');//генерируем исключение
            }

        }
        require_once (ROOT. '/Views/Admin_orders/update.php');
        return true;
    }
}