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

	public function actionContacts () {
        $data['error'] = array();
        $result = false;
		//echo "Работает SiteController<br>";
		//echo "Вызван метод actionContacts<br>";
        if (isset ($_POST['feedback_button'])) {
            $data = UserModel::checkFormContacts();
            if (count($data['error']) == 0) {
                $message = wordwrap($data['feedback_user']['message'], 70, "\r\n");
                //$message = $data['feedback_user']['message'];
                $subject = 'Feedback from site: '.$data['feedback_user']['subject'];
                $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
                $headers = 'From: '. $data['feedback_user']['email'] . "\r\n" .
                    'Reply-To: '.$data['feedback_user']['email'] . "\r\n".
                    'Content-type: text/plain; charset=UTF-8' . "\r\n";
                //echo "Ошибок нет<br>";
                if (mail(ADMIN_EMAIL, $subject, $message, $headers)) {
                    $result = true;
                }else {
                    throw new Exception('Ошибка отправки почты');//генерируем исключение
                }
            }
        }
        require_once (ROOT. '/Views/Site/contacts.php');
        return true;
	}
}

?>