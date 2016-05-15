<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 10.05.2016
 * Time: 14:39
 */
class OrderModel {
    public static function getUserOrdersByIdUser ($id) {
        $id = intval($id);
        //echo $id;
        $db = Db::getConnection();
        $query_prep = "SELECT
        	orders.id_orders,
        	orders.date_order,
        	order_status.status
        	FROM orders
        	INNER JOIN order_status
			ON orders.status = order_status.id_status
        	WHERE orders.id_user = :id
        ";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->execute(array('id' => $id)); // передаем данные
        $result = $dbstmt->fetchAll();
        //echo "<pre>";
        //print_r ($result);
        //echo "</pre>";
        $db = NULL;  //Закрываем соединение
        return $result;
        //exit;
    }
    public static function getTotalAmountOrderByID ($id) {
        $id = intval($id);
        $total=0;
        $db = Db::getConnection();
        $query_prep  = "SELECT
        	products_in_order.quantity,
        	products_in_order.price
        	FROM products_in_order
        	WHERE products_in_order.id_orders = :id
        ";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->execute(array('id' => $id)); // передаем данные
        $result = $dbstmt->fetchAll();
        foreach ($result as $line) {
            $total+=$line['quantity']*$line['price'];
        }
        //echo "<pre>";
        //print_r ($result);
        //echo "</pre>";
        $db = NULL;  //Закрываем соединение
        return $total;
    }

    public static function getAuthUserOrderByIdOrder ($id) {
        $id = intval($id);
        $db = Db::getConnection();
        $idUser = $_SESSION['user']['id_user'];
        $query_prep = "SELECT
			product_categories.singular_category,
			brands.brand,
			products.vendor_code,
			products_in_order.quantity,
			products_in_order.price
			FROM products
			INNER JOIN brands
			ON products.id_brand = brands.id_brand
			INNER JOIN product_categories
			ON products.id_category = product_categories.id_category
			INNER JOIN products_in_order
			ON products.id_product = products_in_order.id_product
			INNER JOIN orders
			ON orders.id_orders = products_in_order.id_orders
			WHERE products_in_order.id_orders = :id
			AND orders.id_user = :idUser
		";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->bindValue(':id', $id, PDO::PARAM_INT);
        $dbstmt->bindValue(':idUser', $idUser, PDO::PARAM_INT);
        if ($dbstmt->execute()) {
            $result = $dbstmt->fetchAll();
            $db = NULL;  //Закрываем соединение
            return $result;
        } else {
            throw new Exception('Ошибка: невозможно получить список заказов авторизованного пользователя из БД!');
        }
    }

    public static function getAdminOrdersList ($pageNumber) {
        $pageNumber=intval($pageNumber);
        $limit = ADMIN_ORDERS_PER_PAGE;
        $offset=($pageNumber-1)*ADMIN_ORDERS_PER_PAGE;
        $db = Db::getConnection();
        $query_prep = "SELECT
            orders.id_orders,
            orders.date_order,
            users_all.name,
            order_status.status,
            users_auth.email
            FROM orders
            INNER JOIN users_all
			ON orders.id_user = users_all.id_user
			INNER JOIN order_status
			ON orders.status = order_status.id_status
			LEFT OUTER JOIN users_auth
			ON users_all.id_user = users_auth.id_user
			ORDER BY orders.id_orders DESC
			LIMIT :orders_limit
			OFFSET :orders_offset
        ";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->bindValue(':orders_limit', $limit, PDO::PARAM_INT);
        $dbstmt->bindValue(':orders_offset', $offset, PDO::PARAM_INT);
        if ($dbstmt->execute()) {
            $result = $dbstmt->fetchAll();
            //echo "<pre>";
            //print_r ($result);
            //echo "</pre>";
            $db = NULL;  //Закрываем соединение
            return $result;
            //exit ('Останов в OrderModel');
        } else {
            throw new Exception('Ошибка: невозможно получить список заказов из БД!');
        }
    }

    public static function getAdminOrdersPageAmount () {
        $db = Db::getConnection();
        $query = "SELECT
            count(*)
		FROM orders
        ";
        $dbstmt = $db->query($query);
        $ordersAmount = $dbstmt->fetchColumn();
        $pagesAmount = ceil($ordersAmount/ADMIN_ORDERS_PER_PAGE);
        return $pagesAmount;
    }

    public static function deleteOrderById ($idOrder) {
        $idOrder = intval($idOrder);
        $db = Db::getConnection();
        $db->beginTransaction();
        // удаляем заказ из таблицы товары в заказах
        $query_prep = "DELETE
            FROM products_in_order
            WHERE products_in_order.id_orders = :id
        ";
        $dbstmt = $db->prepare($query_prep);
        if ($dbstmt->execute(array('id' => $idOrder))) { // передаем данные и выполняем запрос
            // удаляем заказ из таблицы заказов
            $query_prep = "DELETE
              FROM orders
              WHERE orders.id_orders = :id
            ";
            $dbstmt = $db->prepare($query_prep);
            if ($dbstmt->execute(array('id' => $idOrder))) {
                // Если клиент не зарегистрирован в БД, то удаляем и его
                $userData = self::checkUserDataByIdOrder($idOrder); //
                if (!current($userData)) {
                    $query_prep = "DELETE
                      FROM users_all
                      WHERE users_all.id_user = :id
                    ";
                    $dbstmt = $db->prepare($query_prep);
                    if (!$dbstmt->execute(array('id' => key($userData)))) {
                        $db->rollBack(); // откатываем транзакцию
                        $db = NULL;  //Закрываем соединение
                        throw new Exception('Ошибка удаления заказа: невозможно удалить клиента из таблицы клиентов');//генерируем исключение
                    }
                }
                $db->commit(); // Фиксируем транзакцию
                $db = NULL;  //Закрываем соединение
                return true;
            } else {
                $db->rollBack(); // откатываем транзакцию
                $db = NULL;  //Закрываем соединение
                throw new Exception('Ошибка удаления заказа: невозможно удалить заказ из таблицы заказов');//генерируем исключение
            }
        } else {
            throw new Exception('Ошибка удаления заказа: невозможно удалить заказ из таблицы товаров в заказе');//генерируем исключение
        }
    }

    public static function checkUserDataByIdOrder ($idOrder) {
        $db = Db::getConnection();
        //Проверяем пользователя на авторизацию
        $query_prep = "SELECT
            users_all.id_user,
            users_auth.email
            FROM users_auth
            RIGHT OUTER JOIN users_all
            ON users_all.id_user = users_auth.id_user
            INNER JOIN orders
		    ON orders.id_user = users_all.id_user
            WHERE orders.id_orders = :id
        ";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->execute(array('id' => $idOrder)); // передаем данные и выполняем запрос
        $row = $dbstmt->fetch();
        $result[$row['id_user']] = $row['email']; //получаем массив id клиента => email клиента
        return $result;
    }
}