<?php
class CartModel {

	public static function addProductToCart ($id) {
		$productsInCart = array (); // массив товаров в корзине
		$id = intval ($id);		
		//echo $id;
		if (isset($_SESSION['cart'])) { // если в корзине сессии уже есть товары
			//echo "Сессия уже существует<br>";
			$productsInCart = $_SESSION['cart']; // сохраняем товары из корзины в переменной
		}
		if (array_key_exists ($id, $productsInCart)) { // если товар уже есть в корзине
			//echo "Такой товар уже есть в корзине<br>";
			$productsInCart[$id]++; // увеличиваем его количество на единицу
		}else {
			//echo "Такого товара не было в корзине<br>";
			$productsInCart[$id] = 1; // иначе количество товара равно единице
		}
		$_SESSION['cart'] = $productsInCart; // обновляем корзину сессии
		//echo "<pre>";
        //print_r ($_SESSION['cart']);
        //echo "</pre>";	
	}
	
	public static function getCountItemsInCart () {
		$totalProducts = 0;
		if (isset($_SESSION['cart'])) {
			$totalProducts = array_sum ($_SESSION['cart']);			
		}
		return $totalProducts;
	}

	public static function getProductsFromCart () {
        if (isset($_SESSION['cart'])) {
            $idItemsInCart = implode(',', array_keys($_SESSION['cart']));
			//$idItemsInCart = "";
            //echo "<pre>";
            //print_r ($idItemsInCart);
            //echo "</pre>";

            $db = Db::getConnection();
            $query = "SELECT
            products.id_product,
			product_categories.singular_category,
			brands.brand,
			products.vendor_code,
			products.price
			FROM products
			INNER JOIN brands
			ON products.id_brand = brands.id_brand
			INNER JOIN product_categories
			ON products.id_category = product_categories.id_category
			WHERE products.id_product IN ($idItemsInCart)";
            //echo $query . "<br>";
            $dbstmt = $db->query($query);
            $result = $dbstmt->fetchAll(); // Получаем ассоциативный массив данных
            $db = NULL;  //Закрываем соединение
            //echo "<pre>";
            //print_r ($result);
            //echo "</pre>";
			return $result;

        }else {
			return false;
		}
    }

    public static function getPricesForCart () {
        if (isset($_SESSION['cart'])) {
            $idItemsInCart = implode(',', array_keys($_SESSION['cart'])); //получаем строку с id товаров из корзины
            $db = Db::getConnection();
            $query = "SELECT
            products.id_product,
			products.price
			FROM products
			WHERE products.id_product IN ($idItemsInCart)";
            if ($dbstmt = $db->query($query)) {
                while ($row = $dbstmt->fetch()) {
                    $result[$row['id_product']] = $row['price']; //получаем массив id товара => цена товара
                }
                $db = NULL;  //Закрываем соединение
                return $result;
            } else {
                throw new Exception('Ошибка получения цен из БД на товары из корзины');//генерируем исключение
            }
        } else {
            return false;
        }
    }
	
	public static function getCartTotalAmount ($cartProducts) {
		$cartTotalAmount = 0;
		//$cartProducts = self::getProductsFromCart();
		foreach ($cartProducts as $product) {
			$cartTotalAmount = $cartTotalAmount + $product['price']*$_SESSION['cart'][$product['id_product']];
		}
		//echo $cartTotalAmount.'<br>';
		return $cartTotalAmount;
	}

	public static function checkFormOrder () {
		$error = array();
		$order = $_POST['order'];
        if (isset($order['name'])) {
            if (!UserModel::checkName($order['name'])) {
                $error[] = 'Неверное имя';
            }
        }
        if (isset($order['phone'])) {
            if (!UserModel::checkPhone($order['phone'])) {
                $error[] = 'Неверный телефон';
            }
        }
		$order['comment'] = strip_tags (trim($order['comment']));
        $data['error'] = $error;
        $data['order'] = $order;
        return $data;
	}

	public static function addNewOrder ($order) {
		$db = Db::getConnection();
		$db->beginTransaction();
		if (UserModel::checkGuest()) { // Если гость - будем добавлять данные клиента в БД

			$query_prep ="INSERT INTO users_all
				(name, phone)
				VALUES
				(:name, :phone)
			";
			$dbstmt = $db->prepare($query_prep);
			$dbstmt->bindValue(':name', $order['name'], PDO::PARAM_STR);
			$dbstmt->bindValue(':phone', $order['phone'], PDO::PARAM_INT);
			if ($dbstmt->execute()) {
				$idUser = $db->lastInsertId(); // Получаем ID добавленного клиента
			} else {
				throw new Exception('Ошибка регистрации заказа: невозможно добавить нового пользователя в таблицу users_all');//генерируем исключение
			}
		} else {
			$idUser = $_SESSION['user']['id_user']; // Если клиент авторизован - получаем его ID
            //echo '<br>'.$idUser.'<br>';
		}
        $query_prep ="INSERT INTO orders
				(id_user, comment)
				VALUES
				(:id_user, :comment)
		";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->bindValue(':comment', $order['comment'], PDO::PARAM_STR);
        $dbstmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        if ($dbstmt->execute()) { // Добавляем новый заказ в БД
            $idOrder = $db->lastInsertId(); // Получаем ID заказа
            if ($pricesFromCart = self::getPricesForCart()) { // Получаем цены на товары в корзине
            } else {
                throw new Exception('Ошибка получения цен товаров из корзины');//генерируем исключение
            }
            // Формируем запрос для добавления заказанных товаров в БД
            $query = "INSERT INTO products_in_order
                (id_products_in_order, id_orders, id_product, quantity, price)
                VALUES
            ";
            foreach ($_SESSION['cart'] as $productID => $productQantity) {
                $query.='(NULL, '.$idOrder.', '.$productID.', '.$productQantity.', '.$pricesFromCart[$productID].'),';
            }
            $query = rtrim ($query, ',');
            if ($result = $db->query($query)) { // Если запрос успешно выполнен
                $db->commit(); // Фиксируем транзакцию
                $db = NULL;  //Закрываем соединение
                unset ($_SESSION['cart']); // чистим корзину
                return TRUE;
            } else {
                $db->rollBack(); // откатываем транзакцию
                throw new Exception('Ошибка регистрации заказа: невозможно добавить новый заказ в таблицу products_in_order');//генерируем исключение
            }
        } else {
            $db->rollBack(); // откатываем транзакцию
            throw new Exception('Ошибка регистрации заказа: невозможно добавить новый заказ в таблицу orders');//генерируем исключение
        }
	}



}