<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 10.05.2016
 * Time: 14:39
 */
class OrderModel {
    public static function getUserOrdersByID ($id) {
        //echo $id;
        $db = Db::getConnection();
        $query = "SELECT
        	orders.id_orders,
        	orders.date_order,
        	order_status.status
        	FROM orders
        	INNER JOIN order_status
			ON orders.status = order_status.id_status
        	WHERE orders.id_user = $id
        ";
        $dbstmt = $db->query($query);
        $result = $dbstmt->fetchAll();
        //echo "<pre>";
        //print_r ($result);
        //echo "</pre>";
        $db = NULL;  //Закрываем соединение
        return $result;
        //exit;
    }
    public static function getTotalAmountOrderByID ($id) {
        $total=0;
        $db = Db::getConnection();
        $query = "SELECT
        	products_in_order.quantity,
        	products_in_order.price
        	FROM products_in_order
        	WHERE products_in_order.id_orders = $id
        ";
        $dbstmt = $db->query($query);
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

    public static function getUserOrder ($id) {
        $db = Db::getConnection();
        $idUser = $_SESSION['user']['id_user'];
        $query = "SELECT
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
			WHERE products_in_order.id_orders = $id
			AND orders.id_user = $idUser
		";
        $dbstmt = $db->query($query);
        $result = $dbstmt->fetchAll();
        $db = NULL;  //Закрываем соединение
        return $result;
    }
}