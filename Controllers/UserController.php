<?php

/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 14.03.2016
 * Time: 17:33
 */
class UserController {

    public function actionRegistration () {
		$data['error'] = array();
        $result = false;
        //echo "Работает UserController<br>";
        //echo "Вызван метод actionRegistration<br>";
		if (isset ($_POST['registration'])) {
            //echo "Нажата кнопка<br>";
			$data = UserModel::checkFormRegistration();		
			if (count($data['error']) == 0) {
				//echo "Нужно проверить наличие e-mail в БД<br>";
				//echo $data['user']['email'] ."<br>";
				if (UserModel::checkEmailExists($data['user']['email'])) {
					//echo "Такой e-mail уже существует<br>";
                    $data['error'][] = 'Такой e-mail уже существует';
				}else {
					//echo "Такой e-mail встречается впервые<br>";
                    if ($result = UserModel::addNewUser($data['user'])) {
                        //echo "Новый пользователь успешно добавлен<br>";
                    }else {
                        throw new Exception('Ошибка добавления нового пользователя в БД');//генерируем исключение
                    }
				}					
			}
		}
		
		require_once (ROOT. '/Views/User/registration.php');
        return true;

    }

	public static function actionLogin () {
        //echo "Server: ".$_SERVER['HTTP_REFERER']."<br>";
        //echo "Сессия: ".$_SESSION['referer']."<br>";

        $data['error'] = array();
        //echo "Работает UserController<br>";
        //echo "Вызван метод actionLogin<br>";
        if (isset ($_POST['login'])) {
            //echo "Нажата кнопка<br>";
            $data = UserModel::checkFormLogin();
            if (empty($data['error'])) {
                //echo "Ошибок в форме нету<br>";
                    if ($user = UserModel::checkUserData($data['user']['email'], $data['user']['password'])) {
                        UserModel::startAuthenticatedSession($user);

                            header("Location: /");

                    }else {
                        $data['error'][] = "Неправильные данные для входа на сайт";
                    }

            }
        }
        require_once (ROOT. '/Views/User/login.php');
        return true;
    }
	
	public static function actionLogout () {
		//echo "Работает UserController<br>";
        //echo "Вызван метод actionLogout<br>";
		if (isset($_SESSION['user'])) {
			unset ($_SESSION['user']);
		}
		header("Location: /");
		return true;
	}


}