<?php

/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 20.03.2016
 * Time: 11:28
 */
class CabinetController {

    public function actionIndex () {
        //echo "Работает CabinetController<br>";
        //echo "Вызван метод actionIndex<br>";
        //session_start();
        if (UserModel::checkAuthenticatedSession()) {
			//echo "<pre>";
			//print_r ($_SESSION['user']);
			//echo "</pre>";
            //$name = $_SESSION['user']['name'];
			require_once (ROOT. '/Views/Cabinet/index.php');
        }   
        return true;
    }
	
	public function actionEdit () {
		$data['error'] = array();
		$result = false;
		//echo "<pre>";
        //print_r ($_SESSION['user']);
        //echo "</pre>";
		//echo "Работает CabinetController<br>";
        //echo "Вызван метод actionEdit<br>";
        if (UserModel::checkAuthenticatedSession()) {
            if (isset ($_POST['edit'])) {
                //echo "Нажата кнопка<br>";
                $data = UserModel::checkFormEdit();
                if (empty($data['error'])) {
                    //echo "Ошибок в форме нету<br>";
                    if ($result = UserModel::updateUser($data['user'])) {
                        //echo "Изменения успешно внесены<br>";
                    } else {
                        throw new Exception('Ошибка редактирования данных пользователя в БД');//генерируем исключение
                    }
                }
            }
            require_once(ROOT . '/Views/Cabinet/edit.php');
        }
		return true;
	}
	
	public function actionPass () {
		$data['error'] = array();
		$result = false;
		//echo "Работает CabinetController<br>";
        //echo "Вызван метод actionPass<br>";
        if (UserModel::checkAuthenticatedSession()) {
            if (isset ($_POST['pass'])) {
                //echo "Нажата кнопка<br>";
                $data = UserModel::checkFormPass();
                if (empty($data['error'])) {
                    //echo "Ошибок в форме нету<br>";
                    if ($result = UserModel::updatePasswordUser($data['user'])) {
                        //echo "Изменения успешно внесены<br>";
                    } else {
                        throw new Exception('Ошибка смены пароля пользователя в БД');//генерируем исключение
                    }
                }
            }
            require_once(ROOT . '/Views/Cabinet/pass.php');
        }
		return true;
	}
}