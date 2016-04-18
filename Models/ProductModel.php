<?php
class ProductModel {
    	 //
	public static function getProductItemById ($id) {
		//echo "Работает ProductModel<br>";
		//echo "Вызван метод  getProductItemById<br>";
		$id=intval ($id);

		$db = Db::getConnection();
		$query_prep = "SELECT
			product_categories.singular_category,
			product_categories.category,
			brands.brand,
			brands.id_brand,
			product_categories.category_arh,
			products.vendor_code,
			products.product_arh,
			products.price,
			products.simple_descrip,
			products.id_category,
			products.id_product
			FROM products
			INNER JOIN brands
			ON products.id_brand = brands.id_brand
			INNER JOIN product_categories
			ON products.id_category = product_categories.id_category
			WHERE products.id_product = :id_product";
		$dbstmt = $db->prepare($query_prep); // подготавливаем запрос
		$dbstmt->execute(array('id_product' => $id)); // передаем данные
		$productItem=$dbstmt->fetch(); // выполняем запрос
		$db = NULL;  //Закрываем соединение
		return $productItem;
	}

	// Получение списка товаров
	public static function getProductList ($categoryId, $pageNumber) {
		$productsList=array();
		//Изменить порядок сортировки для категорий товаров по возрастанию цены!!!
		$categoryId=intval($categoryId);
		//echo "Страница: $pageNumber<br>";
		$pageNumber=intval($pageNumber);
		//$tempOffset=($pageNumber-1)*PRODUCTS_PER_PAGE;
		//echo "Страница: $pageNumber<br>";
		//echo "Офсет: $tempOffset<br>";
		//echo "Работает ProductModel<br>";
		//echo "Вызван метод  getProductList<br>";
		
		//echo "categoryId  $categoryId<br>";
		//echo "limit  $limit<br>";
		
		if ($categoryId===0){
			$limit=LAST_PRODUCTS_PER_PAGE;		
			$offset=0;
		}
		else{
			$limit=PRODUCTS_PER_PAGE;
			$offset=($pageNumber-1)*PRODUCTS_PER_PAGE;
		}
		$db = Db::getConnection();
		$query_prep = "SELECT
			products.id_product,
			product_categories.singular_category,
			brands.brand,
			products.vendor_code,
			products.simple_descrip,
			products.price
			FROM products
			INNER JOIN brands
			ON products.id_brand = brands.id_brand
			INNER JOIN product_categories
			ON products.id_category = product_categories.id_category
			WHERE product_categories.category_arh = 0
			AND products.product_arh = 0
			AND IF(:category>0, product_categories.id_category =:category, TRUE)
			ORDER BY products.id_product DESC
			LIMIT :products_limit
			OFFSET :products_offset";
		$dbstmt = $db->prepare($query_prep);
		$dbstmt->bindValue(':category', $categoryId, PDO::PARAM_INT);
		$dbstmt->bindValue(':products_limit', $limit, PDO::PARAM_INT);
		$dbstmt->bindValue(':products_offset', $offset, PDO::PARAM_INT);
		$dbstmt->execute();
		$i=0;
		while ($row = $dbstmt->fetch()){
			$productsList[$i]['id_product'] = $row['id_product'];
			$productsList[$i]['singular_category'] = $row['singular_category'];
			$productsList[$i]['brand'] = $row['brand'];
			$productsList[$i]['simple_descrip'] = $row['simple_descrip'];
			$productsList[$i]['vendor_code'] = $row['vendor_code'];
			$productsList[$i]['price'] = $row['price'];		
			$i++;
		}
		$db = NULL;  //Закрываем соединение
		return $productsList;
	}


	// Получаем общее количество товаров в категории с учетом архивных товаров и категорий
	public static function getPagesAmount ($categoryId) {

        $categoryId=intval($categoryId);

		$db = Db::getConnection();
		$query_prep = "SELECT
		count(*)
		FROM products
		INNER JOIN product_categories
		ON products.id_category = product_categories.id_category
		WHERE product_categories.category_arh = 0
        AND products.product_arh = 0
        AND product_categories.id_category =:category";

		$dbstmt = $db->prepare($query_prep); // подготавливаем запрос
		$dbstmt->execute(array('category' => $categoryId)); // передаем данные
		// Равно нулю, если не выбрана категория, чтобы не было пагинации на главной странице
		$productAmount = $dbstmt->fetch(); // выполняем запрос
		//определяем количество страниц пагинации
		$pagesAmount = ceil($productAmount['count(*)']/PRODUCTS_PER_PAGE);
		//echo $pagesAmount;
		$db = NULL;  //Закрываем соединение
        return $pagesAmount;
	}

    // Получение списка товаров
    public static function getAdminProductList ($categoryId, $pageNumber) {
        $productsList=array();
        $categoryId=intval($categoryId);
        $pageNumber=intval($pageNumber);
        $limit = ADMIN_PRODUCTS_PER_PAGE;
        $offset=($pageNumber-1)*ADMIN_PRODUCTS_PER_PAGE;
        $db = Db::getConnection();
        $query_prep = "SELECT
			products.id_product,
			product_categories.singular_category,
			brands.brand,
			products.vendor_code,
			products.product_arh,
			products.price,
			products.simple_descrip
			FROM products
			INNER JOIN brands
			ON products.id_brand = brands.id_brand
			INNER JOIN product_categories
			ON products.id_category = product_categories.id_category
			WHERE IF(:category>0, product_categories.id_category =:category, TRUE)
			ORDER BY products.id_product DESC
			LIMIT :products_limit
			OFFSET :products_offset";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->bindValue(':category', $categoryId, PDO::PARAM_INT);
        $dbstmt->bindValue(':products_limit', $limit, PDO::PARAM_INT);
        $dbstmt->bindValue(':products_offset', $offset, PDO::PARAM_INT);
        $dbstmt->execute();
        $i=0;
        while ($row = $dbstmt->fetch()){
            $productsList[$i]['id_product'] = $row['id_product'];
            $productsList[$i]['singular_category'] = $row['singular_category'];
            $productsList[$i]['brand'] = $row['brand'];
            $productsList[$i]['vendor_code'] = $row['vendor_code'];
            $productsList[$i]['price'] = $row['price'];
			$productsList[$i]['simple_descrip'] = $row['simple_descrip'];
            $productsList[$i]['product_arh'] = $row['product_arh'];
            $i++;
        }
        $db = NULL;  //Закрываем соединение
        return $productsList;
    }

    public static function getAdminPagesAmount ($categoryId) {

        $categoryId=intval($categoryId);

        $db = Db::getConnection();
        $query_prep = "SELECT
		count(*)
		FROM products
		INNER JOIN product_categories
		ON products.id_category = product_categories.id_category
		WHERE IF(:category>0, product_categories.id_category =:category, TRUE)
		";

        $dbstmt = $db->prepare($query_prep); // подготавливаем запрос
        $dbstmt->execute(array('category' => $categoryId)); // передаем данные
        // Равно нулю, если не выбрана категория, чтобы не было пагинации на главной странице
        $productAmount = $dbstmt->fetch(); // выполняем запрос
        //определяем количество страниц пагинации
        $pagesAmount = ceil($productAmount['count(*)']/ADMIN_PRODUCTS_PER_PAGE);
        //echo $pagesAmount;
        $db = NULL;  //Закрываем соединение
        return $pagesAmount;
    }

    public static function deleteProductById ($idProduct) {
        $idProduct=intval($idProduct);

        $db = Db::getConnection();
        $query_prep = "DELETE
        FROM products
        WHERE products.id_product = :id
        ";
        $dbstmt = $db->prepare($query_prep); // подготавливаем запрос
        if ($dbstmt->execute(array('id' => $idProduct))) { // передаем данные и исполняем запрос, 
			$db = NULL;  //Закрываем соединение
			return TRUE; // возвращаем истину, если все гуд
		}
		else {
			return FALSE;
		}
		 
    }
	public static function formCreateProduct () {
		$newProduct = array();
		$error = array();
		$value = array();
		$data = array();
		// Обязательные поля для заполнения плюс сообщения для ошибок ввода данных
		$dataCheck = array ('id_category' => 'Заполните категорию товара!', 'id_brand' => 'Заполните производителя товара!',
		'vendor_code' => 'Заполните артикул товара!', 'price' => 'Заполните цену товара!');
		 // получаем данные о новом товаре
		$newProduct = $_POST['newProduct'];
		// Цикл проверки на незаполненные поля
		foreach ($dataCheck as $key => $text) {
			if (!isset ($newProduct[$key]) || empty($newProduct[$key]) ){
			$error[] = $text;
			}else {
				$value[$key] = $newProduct[$key]; // массив уже введенных данных для подстановки в форму 
			}		
		}
		// Проверка на соответствие поля цены товара числу
		if (!empty($newProduct['price']) && !is_numeric($newProduct['price'])) {
            $error[] = "Цена товара должна быть числом!<br>";
			$value['price'] = preg_replace('/\s/', '', $newProduct['price']); //Удаляем пробелы из цены товара
        }else {
            $newProduct['price'] = abs (intval($newProduct['price'])); // перевод в целое число и устранение знака
            $value['price'] = $newProduct['price'];
        }
        if (!empty($newProduct['url'])) {
            $value['url'] = $newProduct['url'];
        }
        if (!empty($newProduct['simple_descrip'])) {
            $value['simple_descrip'] = $newProduct['simple_descrip'];
        }

		$data['error'] = $error;
		$data['value'] = $value;
		$data['newProduct'] = $newProduct;

		return $data;
	}
	
	public static function createNewProduct ($newProduct) {
		$lastID = "";

		
		$db = Db::getConnection();
		$query_prep ="INSERT INTO products
		(id_category, id_brand, vendor_code, price, simple_descrip, product_arh)
		VALUES
		(:id_category, :id_brand, :vendor_code, :price, :simple_descrip, :product_arh)
		";
		$dbstmt = $db->prepare($query_prep);
		$dbstmt->bindValue(':id_category', $newProduct['id_category'], PDO::PARAM_INT);
		$dbstmt->bindValue(':id_brand', $newProduct['id_brand'], PDO::PARAM_INT);
		$dbstmt->bindValue(':vendor_code', $newProduct['vendor_code'], PDO::PARAM_STR);
		$dbstmt->bindValue(':price', $newProduct['price'], PDO::PARAM_INT);
		$dbstmt->bindValue(':simple_descrip', $newProduct['simple_descrip'], PDO::PARAM_STR);
		$dbstmt->bindValue(':product_arh', $newProduct['product_arh'], PDO::PARAM_INT);
		
		if ($dbstmt->execute()) {
			$lastID = $db->lastInsertId();
			$db = NULL;  //Закрываем соединение
			return $lastID; // Возвращаем ID добавленного товара
		}else {
			return 0;
		}
	}
	
		public static function updateProductById ($idProduct) {
			
		$updateProduct = $_POST['newProduct'];
        $updateProduct['price'] = intval(preg_replace('/\s/', '', $updateProduct['price']));
        $idProduct = intval($idProduct);

		
		$db = Db::getConnection();
		$query_prep ="UPDATE products
		SET
			id_category = :id_category,
			id_brand = :id_brand,
			vendor_code = :vendor_code,
			price = :price,
			simple_descrip = :simple_descrip,
			product_arh = :product_arh
		WHERE id_product = :idProduct
		";
		$dbstmt = $db->prepare($query_prep);
		$dbstmt->bindValue(':id_category', $updateProduct['id_category'], PDO::PARAM_INT);
		$dbstmt->bindValue(':id_brand', $updateProduct['id_brand'], PDO::PARAM_INT);
		$dbstmt->bindValue(':vendor_code', $updateProduct['vendor_code'], PDO::PARAM_STR);
		$dbstmt->bindValue(':price', $updateProduct['price'], PDO::PARAM_INT);
		$dbstmt->bindValue(':simple_descrip', $updateProduct['simple_descrip'], PDO::PARAM_STR);
		$dbstmt->bindValue(':product_arh', $updateProduct['product_arh'], PDO::PARAM_INT);
		$dbstmt->bindValue(':idProduct', $idProduct, PDO::PARAM_INT);	
		
		if ($dbstmt->execute()) {
			$db = NULL;  //Закрываем соединение
			return TRUE;
		}
		else {
			return FALSE;
		}		

	}
	
	public static function updateImageById ($idProduct) {
		Echo "Функция обработки изображений<br>";
		$medium_width = 227; $medium_height = 227; // размеры фото в карточке товара
		$small_width = 124; $small_height = 124; // размеры фото в списке товаров
		$updateProduct = $_POST['newProduct'];
		$url = $updateProduct['url'];
		if ($image = file_get_contents ($url)) {
			// Генерируем имя для временного файла изображения
			$tmp_name = ROOT . '/Template/temp/tmp_' . $idProduct;
			//echo 'Имя временного файла: ' . $tmp_name . '<br>';
			//Сохраняем изображение            
			file_put_contents( $tmp_name, $image );
			//Удаляем переменную
			unset ($image);
			// если получим массив, то принятый файл является изображением
			if (is_array ($info = getimagesize ($tmp_name ))) {
				//echo "<pre>";
				//print_r ($info);
				//echo "</pre>";
				//Вычисляем тип изображения
				$type = trim( strrchr( $info['mime'], '/' ), '/' );	
				//echo 'Тип файла: ' . $type . '<br>';
				// проверяем соответствие типа изображения разрешенным
				if ($type=='jpeg') {
					//Получаем ширину и высоту изображения
					list( $width, $height ) = $info;
					echo 'Ширина изображения: ' . $width . '<br>';
					echo 'Высота изображения: ' . $height . '<br>';

                    if ($width >= $height) {
                        $medium_height = ceil ($height/$width*227);
                        $small_height = ceil ($height/$width*124);
                    }else {
                        $medium_width = ceil ($width/$height*227);
                        $small_width = ceil ($width/$height*124);
                    }
					//Создаём ресурс изображения
					$src_image = imagecreatefromjpeg ($tmp_name);	

					//Создаём новое изображение medium-качества
					$dst_image = imagecreatetruecolor ($medium_width, $medium_height);		
					//Изменяем размер картинки
					imagecopyresampled ($dst_image, $src_image, 0, 0, 0, 0, $medium_width, $medium_height, $width, $height );
					if (imagejpeg ($dst_image, ROOT . '/Template/images/' . $idProduct . '_medium.jpg')) {						
						//echo "Медиум-файл успешно записан!<br>";
						imagedestroy ($dst_image); // Чистим память
					}else {
                        throw new Exception('Ошибка: невозможно записать файл изображения!');
					}
					
					$dst_image = imagecreatetruecolor ($small_width, $small_height);	
					imagecopyresampled ($dst_image, $src_image, 0, 0, 0, 0, $small_width, $small_height, $width, $height );
					if (imagejpeg ($dst_image, ROOT . '/Template/images/' . $idProduct . '_small.jpg')) {						
						//echo "Small-файл успешно записан!<br>";
						imagedestroy ($dst_image); // Чистим память
					}else {
                        throw new Exception('Ошибка: невозможно записать файл изображения!');
					}
					imagedestroy ($src_image); // Чистим память
					if (unlink ($tmp_name)) { // Удаляем временный файл
						echo "Временный файл успешно удален!<br>";	
					}
				
				}else {
                    throw new Exception('Ошибка: допускается только jpeg-изображение!');
				} 
			}else {
                throw new Exception('Ошибка: файл ' . $tmp_name . ' не является изображением!');
			}
		}else {
            throw new Exception('Ошибка: файл по адресу ' . $url . ' невозможно загрузить!');
		}
		return true;
	}
}


?>