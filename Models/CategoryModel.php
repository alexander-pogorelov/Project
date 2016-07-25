<?php
class CategoryModel {
	
	public static function getCategoriesList () {
		$categoriesList = array ();
		$db = Db::getConnection();
		//echo "Соединение в БД установлено<br>";
		$query = "SELECT
			product_categories.id_category,			
			product_categories.category
			FROM product_categories
			WHERE product_categories.category_arh = 0
			ORDER BY product_categories.category_sort";
		$result = $db->query($query);
		$i=0;
		while ($row = $result->fetch()){
			$categoriesList[$i]['id_category'] = $row['id_category'];			
			$categoriesList[$i]['category'] = $row['category'];
			$i++;
		}
		$db = NULL;  //Закрываем соединение
		//var_dump ($categoriesList);
		return $categoriesList;
	}

	public static function getAdminCategoriesList () {
		$categoriesList = array ();
		$db = Db::getConnection();
		$query = "SELECT
			product_categories.id_category,
			product_categories.category_sort,
			product_categories.category_arh,
			product_categories.singular_category,
			product_categories.category
			FROM product_categories
			ORDER BY product_categories.category_sort";
		$result = $db->query($query);
		$i=0;
		while ($row = $result->fetch()){
			$categoriesList[$i]['id_category'] = $row['id_category'];
			$categoriesList[$i]['category_sort'] = $row['category_sort'];
			$categoriesList[$i]['category'] = $row['category'];
			$categoriesList[$i]['singular_category'] = $row['singular_category'];
			$categoriesList[$i]['category_arh'] = $row['category_arh'];
			
			$i++;
		}
		$db = NULL;  //Закрываем соединение
		//var_dump ($categoriesList);
		return $categoriesList;
	}
	
    public static function deleteCategoryById ($categoryId) {
        $categoryId=intval($categoryId);

        $db = Db::getConnection();
        $query_prep = "DELETE
        FROM product_categories
        WHERE product_categories.id_category = :id
        ";
        $dbstmt = $db->prepare($query_prep); // подготавливаем запрос
        if ($dbstmt->execute(array('id' => $categoryId))) { // передаем данные и исполняем запрос, 
			$db = NULL;  //Закрываем соединение
			return TRUE; // возвращаем истину, если все гуд
		}
		else {
			return FALSE;
		}
		 
    }
	
	public static function formCreateCategory () {
		$newCategory = array();
		$error = array();
		$value = array();
		$data = array();
		// Обязательные поля для заполнения плюс сообщения для ошибок ввода данных
		$dataCheck = array ('category' => 'Заполните категорию товара!', 'singular_category' => 'Заполните префикс категории!');
		//var_dump($dataCheck);
		 // получаем данные о новой категории товара
		$newCategory = $_POST['newCategory'];
		// Проверка на пустое поле
		foreach ($dataCheck as $key => $text) {
			//echo "Ключ: " . $key . "<br>";
			if (!isset($newCategory[$key]) || empty($newCategory[$key])) {
				$error[] = $text;
				var_dump($error);
			} else {
				$value[$key] = $newCategory[$key];
			}
		}
		// Проверка на соответствие поля цены товара числу
		if (!is_numeric($newCategory['category_sort'])) {
			$error[] = "Порядковый номер в сортировке должен быть числом!<br>";
		}else {
			$newCategory['category_sort'] = abs (intval($newCategory['category_sort'])); // перевод в целое число и устранение знака
			$value['category_sort'] = $newCategory['category_sort'];
		}
		$data['error'] = $error;
		$data['value'] = $value;
		$data['newCategory'] = $newCategory;
		//echo "<pre>";
		//print_r ($data);
		//echo "</pre>";

		return $data;
	}
	
	public static function createNewCategory ($newCategory) {

		$db = Db::getConnection();
		$query_prep ="INSERT INTO product_categories
		(category, category_sort, category_arh, singular_category)
		VALUES
		(:category, :category_sort, :category_arh, :singular_category)
		";
		$dbstmt = $db->prepare($query_prep);
		$dbstmt->bindValue(':category', $newCategory['category'], PDO::PARAM_STR);
		$dbstmt->bindValue(':singular_category', $newCategory['singular_category'], PDO::PARAM_STR);
		$dbstmt->bindValue(':category_sort', $newCategory['category_sort'], PDO::PARAM_INT);
		$dbstmt->bindValue(':category_arh', $newCategory['category_arh'], PDO::PARAM_INT);
		if ($dbstmt->execute()) {
			$db = NULL;  //Закрываем соединение
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

    public static function getCategoryItemById ($categoryId){
        $categoryId=intval($categoryId);

        $db = Db::getConnection();
        $query_prep = "SELECT
			product_categories.id_category,
		    product_categories.category,
		    product_categories.singular_category,
		    product_categories.category_sort,
		    product_categories.category_arh
			FROM product_categories
			WHERE product_categories.id_category = :id_category";
        $dbstmt = $db->prepare($query_prep); // подготавливаем запрос
        $dbstmt->execute(array('id_category' => $categoryId)); // передаем данные
        $categoryItem=$dbstmt->fetch(); // выполняем запрос
        $db = NULL;  //Закрываем соединение
        return $categoryItem;
    }

    public static function updateCategoryById ($categoryId) {
        $updateCategory = $_POST['newCategory'];
        $db = Db::getConnection();
        $query_prep ="UPDATE product_categories
		SET
			category = :category,
			singular_category = :singular_category,
			category_sort = :category_sort,
			category_arh = :category_arh
		WHERE id_category = :id_category
		";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->bindValue(':category_sort', $updateCategory['category_sort'], PDO::PARAM_INT);
        $dbstmt->bindValue(':category_arh', $updateCategory['category_arh'], PDO::PARAM_INT);
        $dbstmt->bindValue(':category', $updateCategory['category'], PDO::PARAM_STR);
        $dbstmt->bindValue(':singular_category', $updateCategory['singular_category'], PDO::PARAM_STR);
        $dbstmt->bindValue(':id_category', $categoryId, PDO::PARAM_INT);
        if ($dbstmt->execute()) {
            $db = NULL;  //Закрываем соединение
            return TRUE;
        }
        else {
            return FALSE;
        }
    }


}


?>