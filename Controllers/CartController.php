<?php

/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 14.03.2016
 * Time: 17:33
 */
class CartController {

    public function actionAdd ($id) {
		CartModel::addProductToCart ($id); // Добавляем товар в корзину сессии
		header('Location: ' . $_SERVER['HTTP_REFERER']); // Возвращаемся на исходную страницу сайта
		//exit;
        return true;
    }
    public function actionAddAjax ($idProduct) {
        CartModel::addProductToCart ($idProduct); // Добавляем товар в корзину сессии
        //echo "Товар добавлен в корзину";
        //echo CartModel::getCountItemsInCart();
        echo json_encode (CartModel::getAjaxData($idProduct));
        return true;
    }
	
	public function actionIndex () {
        $categoryId=0;
		//echo "Работает CartController<br>";
        //echo "Вызван метод actionIndex<br>";
		// Получение списка меню категорий
		$categories = CategoryModel::getCategoriesList();
        if (CartModel::getCountItemsInCart() > 0) {
            //echo "В корзине есть товары<br>";
            //echo "<pre>";
            //print_r ($_SESSION['cart']);
            //echo "</pre>";
            if ($productsFromCart = CartModel::getProductsFromCart()) {
				//echo "<pre>";
				//print_r ($productsFromCart);
				//echo "</pre>";
				$cartTotalAmount = CartModel::getCartTotalAmount ($productsFromCart);
				//$cartTotalAmount = CartModel::getCartTotalAmount ();
			}else {
				throw new Exception('Ошибка получения товаров из корзины');//генерируем исключение
			}
        }
		require_once (ROOT. '/Views/Cart/index.php');
		return true;
	}
	
	public function actionDelete ($id) {// удаление товара из корзины
		unset ($_SESSION['cart'][$id]);
		header('Location: ' . $_SERVER['HTTP_REFERER']); // Возвращаемся на исходную страницу сайта
		return true;
	}
    public function actionDelAjax ($idProduct) {// удаление товара из корзины
        unset ($_SESSION['cart'][$idProduct]);
        echo json_encode (CartModel::getAjaxData($idProduct));
        //echo "<pre>";
        //print_r (CartModel::getAjaxData($idProduct));
        //echo "<pre>";
        return true;
    }


    public function actionCheckout() {
        $data['error']=array();
        $result = false;
        $categoryId = 0;
        // Получение списка меню категорий
        $categories = CategoryModel::getCategoriesList();
        //echo "Работает CartController<br>";
        //echo "Вызван метод actionCheckout<br>";
        $countItemsInCart = CartModel::getCountItemsInCart();
        if ($countItemsInCart > 0) {
            $cartTotalAmount = CartModel::getCartTotalAmount(CartModel::getProductsFromCart());
        } else {
            header('Location: /'); // Возвращаемся на главную страницу сайта
            exit;
        }
        if (isset ($_POST['order_button'])) {
            //echo "Нажата кнопка<br>";
            //echo mb_strlen('ф').'<hr>';
            //echo mb_strlen('a').'<hr>';
            $data = CartModel::checkFormOrder();
            if (count($data['error']) == 0) {
                //echo "Ошибок нет<br>";
                if (!$result = CartModel::addNewOrder($data['order'])) {
                    throw new Exception('Ошибка добавления нового заказа в БД');//генерируем исключение
                }
            }
        }
        require_once(ROOT . '/Views/Cart/checkout.php');
        return true;
    }

    public static function actionMinus ($idProduct) {
        //echo "Работает CartController<br>";
        //echo "Вызван метод actionMinus<br>";
        CartModel::decrementProductInCart($idProduct);
        header('Location: /cart');
        return true;
    }
/*
    public static function actionPlus ($idProduct) {
        //echo "Работает CartController<br>";
        //echo "Вызван метод actionPlus<br>";
        CartModel::incrementProductInCart($idProduct);
        header('Location: /cart');
        return true;
    }
*/
    public static function actionMinusAjax ($idProduct) {
        CartModel::decrementProductInCart($idProduct);
        // echo CartModel::getCountItemsInCart();
        //echo json_encode ($_SESSION['cart']);
        echo json_encode (CartModel::getAjaxData($idProduct));
        return true;
    }

}