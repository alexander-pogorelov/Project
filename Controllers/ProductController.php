<?php
class ProductController {
	
	public function actionView ($id) { // Просмотр конкретного товара
		$productItem=array();
		$categories = array ();
		$categoryId = 0;
		$id = intval($id);
		//echo "Работает ProductController<br>";
		//echo "Вызван метод  actionView<br>";
		//echo "Переданы параметры: <br>";
		//echo "brand: $brand<br>";
		//echo "id: $id<br>";
		
		$categories = CategoryModel::getCategoriesList();
		
		if ($id){
			// Получаем данные о товаре
			$productItem=ProductModel::getProductItemById($id);
			// Получаем список товаров той же категории
			$similarProducts = ProductModel::getProductList($productItem['id_category'], 1);
			//echo "<pre>";
			//print_r ($similarProducts);
			//echo "</pre>";

		}else {
			throw new Exception('Ошибка: ID товара не получен!');
		}

		//echo "<pre>";
		//print_r ($productItem);
		//echo "</pre>";

		
		//echo ROOT. '/Views/Product/view.php';
		require_once (ROOT. '/Views/Product/view.php');
			
		return true;
	}

	/*
	public function actionIndex () { // Просмотр списка товаров		
		echo "Работает ProductController<br>";
		echo "Вызван метод  actionIndex<br>";		
		echo "Просмотр списка товаров<hr>";
		
		$productsList=array();
		//$productsList=(new ProductModel)->getProductList(); 
		$productsList=ProductModel::getProductList(); 
		echo "<pre>";
		print_r ($productsList);
		echo "</pre>";
		
		
		
		
		return true;
	}
	*/
}


?>