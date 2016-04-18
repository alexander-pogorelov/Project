<?php


class AdminCategoryController {

    public function actionIndex () {
        //echo "Работает AdminCategoryController<br>";
        //echo "Вызван метод actionIndex<br>";
        $CategoriesList = CategoryModel::getAdminCategoriesList();			
        require_once (ROOT. '/Views/Admin_category/index.php');		
        return true;		
    }	
	
	public function actionDelete ($categoryId) {
		//echo "Работает AdminCategoryController<br>";
        //echo "Вызван метод actionDelete<br>";
		if (isset ($_POST['delete'])) {
            //echo "Нажата кнопка";
			if (CategoryModel::deleteCategoryById($categoryId)) {
                header ("Location: /admin/category"); // Нужен ли полный путь для header????
                exit;
            }else {
                throw new Exception('Ошибка удаления категории товара из базы');//генерируем исключение
            }
        }		
		require_once (ROOT. '/Views/Admin_category/delete.php');
		return true;
	}
	
	public function actionCreate () {
		//echo "Работает AdminCategoryController<br>";
        //echo "Вызван метод actionCreate<br>";
		$data['error'] = array();
        $data['value'] = array();
        $data['newCategory'] = array();
        if (isset($_POST['create'])) {
            //echo "Нажата кнопка добавления товара<br>";
            $data = CategoryModel::formCreateCategory();
			if (count($data['error']) == 0) {
				echo "Ошибок нету!!!<br>";
				//создаем запрос на добавление данных				
				if (CategoryModel::createNewCategory($data['newCategory'])) {
					header ("Location: /admin/category"); // Нужен ли полный путь для header????
					exit;
				}else {
					throw new Exception('Ошибка добавления новой категории товара в базу данных');//генерируем исключение
				}				
			}			
        }		
		require_once (ROOT. '/Views/Admin_category/create.php');
		return true;
	}

	public function actionUpdate ($categoryId) {
		//echo "Работает AdminCategoryController<br>";
		//echo "Вызван метод actionUpdate<br>";
		$categoryItem = CategoryModel::getCategoryItemById($categoryId);
        //echo "<pre>";
        //print_r ($categoryItem);
        //echo "</pre>";
        if (isset ($_POST['update'])) {
            //echo "Нажата кнопка";
            if (CategoryModel::updateCategoryById($categoryId)) {
                header ("Location: /admin/category"); // Нужен ли полный путь для header????
                exit;
            }else {
                throw new Exception('Ошибка обновления категории товара из базы');//генерируем исключение
            }
        }

		require_once (ROOT. '/Views/Admin_category/update.php');
		return true;
	}
}