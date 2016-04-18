<?php
class SiteController {
	
	public function actionIndex ($categoryId=0, $pageNumber=1) {
		$categories = array ();
		$latestProducts = array ();
		//echo "Работает SiteController<br>";
		//echo "Вызван метод actionIndex<br>";
		//echo "Категория: $categoryId<br>";
		//echo "Страница: $pageNumber<br>";
		//echo ROOT . '/views/index.php'."<br>";

		// Получение списка меню категорий
		$categories = CategoryModel::getCategoriesList();
		//var_dump ($categories);

        // получение списка товаров (последние товары или все товары по категории
		$latestProducts = ProductModel::getProductList($categoryId, $pageNumber);

        // Получение количества страниц товаров по категории для пагинации
        $pagesAmount = ProductModel::getPagesAmount($categoryId);
        //echo 'Всего товаров в категории: '.$productAmount;
        //Запускаем пагинацию
        $pagination = new PaginationUri($pageNumber, $pagesAmount, 'page=');
        $pagination->run();
        //echo $pagination->getPaginationList();
        // Подключаем вьюшку
		require_once (ROOT. '/Views/Site/index.php');
		//var_dump ($page);
        // возвращаем истину, чтобы закончить цикл поиска внутренних маршрутов
		return true;
	}
}

?>