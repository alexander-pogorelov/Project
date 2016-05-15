<?php

/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 07.03.2016
 * Time: 13:32
 */
class AdminProductController extends Admin {

    public function actionIndex ($pageNumber=1) {

        //echo "Работает AdminProductController<br>";
        //echo "Вызван метод actionIndex<br>";
        $pageNumber = intval($pageNumber);
        // Получение общего количества страниц товаров по категории для пагинации
        $pagesAmount = ProductModel::getAdminPagesAmount($categoryId=0);
        if ($pageNumber > $pagesAmount) {
            $pageNumber = $pagesAmount;
        }
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }

        $productsList = ProductModel::getAdminProductList($categoryId=0,$pageNumber);



        //echo 'Всего товаров в категории: '.$productAmount;


        //echo 'Страница пагинации: '.$pagesAmount.'<br>';
        //exit;
        //Запускаем пагинацию
        $pagination = new PaginationUri($pageNumber, $pagesAmount, 'page=');
        $pagination->run();

        require_once (ROOT. '/Views/Admin_product/index.php');
        return true;
    }

    /**
     * @param $idProduct
     * @return bool
     * @throws Exception
     */
    public function actionDelete ($idProduct) {
        //echo "Работает AdminProductController<br>";
        //echo "Вызван метод actionDelete<br>";
        if (isset ($_POST['delete'])) {
            //echo "Нажата кнопка";
            if (ProductModel::deleteProductById($idProduct)) {
                header ("Location: /admin/product"); // Нужен ли полный путь для header????
                exit;
            }else {
                throw new Exception('Ошибка удаления товара из базы');//генерируем исключение
            }
        }
        require_once (ROOT. '/Views/Admin_product/delete.php');
        return true;
    }

    /**
     * @return bool
     */
    public function actionCreate () {
        $data['error'] = array();
        $data['value'] = array();
        $data['newProduct'] = array();

        //echo "Работает AdminProductController<br>";
        //echo "Вызван метод actionCreate<br>";
        $categoriesList = CategoryModel::getAdminCategoriesList();
        //var_dump($categoriesList);
        $brandList = BrandModel::getAdminBrandList();
        //var_dump($brandList);
        if (isset($_POST['create'])) {
            //echo "Нажата кнопка добавления товара<br>";
            $data = ProductModel::formCreateProduct();
			if (count($data['error']) == 0) {
				//echo "Ошибок нету!!!<br>";
				//создаем запрос на добавление данных
				if ($lastID=ProductModel::createNewProduct($data['newProduct'])) {

                    //Добавить возвращение ID последней записи!!!!

                    if (!empty ($_POST['newProduct']['url'])) { // Если введен URL картинки
                        //echo "<pre>";
                        //print_r ($_POST['newProduct']['url']);
                        //echo "</pre>";
                        if (!ProductModel::updateImageById($lastID)) throw new Exception('Ошибка обновления изображения товара');//генерируем исключение
                    }


					header ("Location: /admin/product"); // Нужен ли полный путь для header????
                    //echo 'ID добавленного товара: ' . $lastID . '<br>';
					exit;
				}else {
					throw new Exception('Ошибка добавления товара в базу данных');//генерируем исключение
				}
			}
        }
        require_once (ROOT. '/Views/Admin_product/create.php');
        return true;
    }

    public function actionUpdate ($idProduct) {
        //echo "Работает AdminProductController<br>";
        //echo "Вызван метод actionUpdate<br>";
        $categoriesList = CategoryModel::getAdminCategoriesList();
        $brandList = BrandModel::getAdminBrandList();
        $productItem = ProductModel::getProductItemById($idProduct);
        //echo "<pre>";
        //print_r ($productItem);
        //echo "</pre>";
        //echo "Нажата кнопка";
		 if (isset ($_POST['update'])) {
			if (!empty ($_POST['newProduct']['url'])) { // Если введен URL картинки
				//echo "<pre>";
				//print_r ($_POST['newProduct']['url']);
				//echo "</pre>";
				if (!ProductModel::updateImageById($idProduct)) throw new Exception('Ошибка обновления изображения товара');//генерируем исключение
			}
            if (ProductModel::updateProductById($idProduct)) {
                header ("Location: /admin/product"); // Нужен ли полный путь для header????
                exit;
            }else {
                throw new Exception('Ошибка обновления товара из базы');//генерируем исключение
            }
        }

        require_once (ROOT. '/Views/Admin_product/update.php');
        return true;
    }
}