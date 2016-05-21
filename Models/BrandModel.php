<?php
class BrandModel {

	public static function getAdminBrandList () {
		$brandList = array ();
		$db = Db::getConnection();
		$query = "SELECT
			brands.id_brand,
			brands.brand
			FROM brands
			ORDER BY brands.brand";
		$result = $db->query($query);
		$i=0;
		while ($row = $result->fetch()){
			$brandList[$i]['id_brand'] = $row['id_brand'];
			$brandList[$i]['brand'] = $row['brand'];
			$i++;
		}
		$db = NULL;  //Закрываем соединение
		//var_dump ($categoriesList);
		return $brandList;
	}

	public static function deleteBrandById($brandId) {
        $brandId=intval($brandId);

        $db = Db::getConnection();
        $query_prep = "DELETE
        FROM brands
        WHERE brands.id_brand = :id
        ";
        $dbstmt = $db->prepare($query_prep); // подготавливаем запрос
        if ($dbstmt->execute(array('id' => $brandId))) { // передаем данные и исполняем запрос,
			$db = NULL;  //Закрываем соединение
			return TRUE; // возвращаем истину, если все гуд
		}
		else {
			return FALSE;
		}
	}

    public static function formCreateBrand () {
        $newBrand = array();
        $error = array();
        $value = array();
        $data = array();
        //var_dump($dataCheck);
        // получаем данные о новой категории товара
        $newBrand = $_POST['newBrand'];
        //var_dump($newBrand);
        // Проверка на пустое поле
        if (!isset($newBrand['brand']) || empty($newBrand['brand'])) {
            $error[] = 'Заполните поле брэнда товара';

        } else {
                $value['brand'] = $newBrand['brand'];
        }
        $data['error'] = $error;
        $data['value'] = $value;
        $data['newBrand'] = $newBrand;
        echo "<pre>";
        print_r ($data);
        echo "</pre>";

        return $data;
    }

    public static function createNewBrand ($newBrand) {

        $db = Db::getConnection();
        $query_prep ="INSERT INTO brands
		(brand)
		VALUES
		(:brand)
		";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->bindValue(':brand', $newBrand['brand'], PDO::PARAM_STR);

        if ($dbstmt->execute()) {
            $db = NULL;  //Закрываем соединение
            return TRUE;
        }
        else {
            return FALSE;
        }

    }

    public static function getBrandItemById ($brandId) {
        $brandId=intval($brandId);

        $db = Db::getConnection();
        $query_prep = "SELECT
			brands.brand
			FROM brands
			WHERE brands.id_brand = :id_brand";
        $dbstmt = $db->prepare($query_prep); // подготавливаем запрос
        $dbstmt->execute(array('id_brand' => $brandId)); // передаем данные
        $brandItem=$dbstmt->fetch(); // выполняем запрос
        $db = NULL;  //Закрываем соединение
        return $brandItem;
    }

    public static function updateBrandById ($brandId) {
        $updateBrand = $_POST['newBrand'];
        //echo "<pre>";
        //print_r ($updateBrand);
        //echo "</pre>";

        $db = Db::getConnection();
        $query_prep ="UPDATE brands
		SET
			brand = :brand
		WHERE id_brand = :id_brand
		";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->bindValue(':brand', $updateBrand['brand'], PDO::PARAM_STR);
        $dbstmt->bindValue(':id_brand', $brandId, PDO::PARAM_INT);


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