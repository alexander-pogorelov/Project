<?php
class CartModel {

	public static function addProductToCart ($id) {
		$productsInCart = array (); // массив товаров в корзине
		$id = intval ($id);		
		//echo $id;
		if (isset($_SESSION['cart'])) { // если в корзине сессии уже есть товары
			//echo "Сессия уже существует<br>";
			$productsInCart = $_SESSION['cart']; // сохраняем товары в корзине в переменной
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
            //echo "<pre>";
            //print_r ($result);
            //echo "</pre>";
			return $result;

        }else {
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
}