<?php
class UserModel {

	public static function checkFormRegistration () {
		
		$error = array();
		$user = $_POST['user'];
		//echo "<pre>";
        //print_r ($user);
        //echo "</pre>";

        if (!self::checkPhone($user['phone'])) {
            $error[] = 'Неверный телефон';
		}
        if (!self::checkName($user['name'])) {
            $error[] = 'Неверное имя';
        }
		if (!self::checkEmail($user['email'])) {
            $error[] = 'Неверный e-mail';
        }
		if (!self::checkPassword($user['password'])) {
            $error[] = 'Неверный пароль';
        }
		$data['error'] = $error;
		$data['user'] = $user;
		return $data;
	}

    public static function checkFormContacts () {
        $error = array();
        $feedback_user = $_POST['feedback_user'];
        if (!self::checkEmail($feedback_user['email'])) {
            $error[] = 'Неверный e-mail';
        }
        if (empty($feedback_user['subject']) || ($feedback_user['subject']!=preg_replace('/[\s]+/u', ' ', trim($feedback_user['subject'])))) {
            $error[] = 'Неверная тема сообщения';
            $feedback_user['subject'] = preg_replace('/[\s]+/u', ' ', trim($feedback_user['subject']));
        }
        if (empty($feedback_user['message']) || ($feedback_user['message']!=strip_tags(preg_replace('/[ \t]+/u', ' ', trim($feedback_user['message']))))) {
            $error[] = 'Неверное сообщение';
            $feedback_user['message'] = strip_tags(preg_replace('/[ \t]+/u', ' ', trim($feedback_user['message'])));
        }
        $data['error'] = $error;
        $data['feedback_user'] = $feedback_user;
        return $data;
    }

    public static function checkFormLogin () {
        $error = array();
        $user = $_POST['user'];
        if (!self::checkEmail($user['email'])) {
            $error[] = 'Неверный e-mail';
        }
        if (!self::checkPassword($user['password'])) {
            $error[] = 'Неверный пароль';
        }
        $data['error'] = $error;
        $data['user'] = $user;
        return $data;

    }
	
	public static function checkFormEdit () {
		$error = array();
        $user = $_POST['user'];

        if (!self::checkPhone($user['phone'])) {
            $error[] = 'Неверный телефон';
        }
		if (!self::checkName($user['name'])) {
            $error[] = 'Неверное имя';
        }
		if (!self::checkEmail($user['email'])) {
            $error[] = 'Неверный e-mail';
        }
		$data['error'] = $error;
		$data['user'] = $user;
		return $data;
	}
	
	public static function checkFormPass () {
		$error = array();
        $user = $_POST['user'];
		if (!self::checkPassword($user['password'])) {
            $error[] = 'Неверный пароль';
        }
        $data['error'] = $error;
        $data['user'] = $user;
        return $data;
	}
	
	public static function checkEmailExists ($email) {
	    //echo $email.'<br>' ;
	    $db = Db::getConnection();
	    $query_prep ="SELECT
	    COUNT(*)
	    FROM users_auth
	    WHERE users_auth.email = :email
	    ";
	    $dbstmt = $db->prepare($query_prep); // подготавливаем запрос
	    $dbstmt->execute(array('email' => $email));
        $db = NULL;  //Закрываем соединение
	    if ($dbstmt->fetchColumn()) { // передаем данные и исполняем запрос,

		    return TRUE; // возвращаем истину, если все гуд
	    }
	    else {
		return FALSE;
	    }
	}

    public static function checkUserData ($email, $password) {
        //echo $email . '<br>';
        $db = Db::getConnection();
        $query_prep = "SELECT
	    users_all.id_user,
	    users_auth.email,
		users_all.phone,
	    users_all.name,
	    users_auth.hash
	    FROM users_all
	    INNER JOIN users_auth
		ON users_all.id_user = users_auth.id_user
	    WHERE users_auth.email = :email
	    ";
        $dbstmt = $db->prepare($query_prep); // подготавливаем запрос
        $dbstmt->execute(array('email' => $email)); // передаем данные и исполняем запрос,
        $result = $dbstmt->fetchAll(); // Получаем ассоциативный массив данных
        $db = NULL;  //Закрываем соединение
        if (!empty($result)) {
            if (password_verify($password, $result[0]['hash'])) {
                //echo 'Пароль верен!<br>';
                return $result[0];
            }else {
                //echo "Неправильный пароль!<br>";
            return false;
            }
        }else {
            //echo "E-mail не найден в БД!<br>";
            return false;
        }
    }

    public static function addNewUser ($newUser) {
        //Добавление данных пользователя в одну таблицу
        $hash = password_hash($newUser['password'], PASSWORD_BCRYPT);
        $db = Db::getConnection();
        //Добавление данных пользователя в две таблицы
        $db->beginTransaction();
        $query_prep ="INSERT INTO users_all
		(name, phone)
		VALUES
		(:name, :phone)
		";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->bindValue(':name', $newUser['name'], PDO::PARAM_STR);
        $dbstmt->bindValue(':phone', $newUser['phone'], PDO::PARAM_INT);
        if ($dbstmt->execute()) {
            $lastID = $db->lastInsertId();
            $query_prep ="INSERT INTO users_auth
		    (id_user, email, hash)
		    VALUES
		    (:id_user, :email, :hash)
		    ";
            $dbstmt = $db->prepare($query_prep);
            $dbstmt->bindValue(':id_user', $lastID, PDO::PARAM_INT);
            $dbstmt->bindValue(':email', $newUser['email'], PDO::PARAM_STR);
            $dbstmt->bindValue(':hash', $hash, PDO::PARAM_STR);
            if ($dbstmt->execute()) {
                $db->commit();
                $db = NULL;  //Закрываем соединение
                return TRUE;
            }else {
                $db->rollBack();
                throw new Exception('Ошибка добавления нового пользователя в таблицу users_auth');//генерируем исключение
            }
        }
        else {
            throw new Exception('Ошибка добавления нового пользователя в таблицу users_all');//генерируем исключение
        }
    }
	
	public static function updateUser ($user) {
		$db = Db::getConnection();
        $db->beginTransaction();

		$query_prep ="UPDATE users_all
		SET
			name = :name,
			phone = :phone
		WHERE id_user = :id_user
		";
		$dbstmt = $db->prepare($query_prep);
		$dbstmt->bindValue(':name', $user['name'], PDO::PARAM_STR);
		$dbstmt->bindValue(':phone', $user['phone'], PDO::PARAM_INT); // определяем данные для ввода телефона
		$dbstmt->bindValue(':id_user', $_SESSION['user']['id_user'], PDO::PARAM_INT);

		if ($dbstmt->execute()) {
            $query_prep ="UPDATE users_auth
		    SET
			email = :email
		    WHERE id_user = :id_user
		    ";
            $dbstmt = $db->prepare($query_prep);
            $dbstmt->bindValue(':email', $user['email'], PDO::PARAM_STR);
            $dbstmt->bindValue(':id_user', $_SESSION['user']['id_user'], PDO::PARAM_INT);
            if ($dbstmt->execute()) {
                $db->commit();
                $db = NULL;  //Закрываем соединение
                $_SESSION['user']['name'] = $user['name'];
                $_SESSION['user']['email'] = $user['email'];
                $_SESSION['user']['phone'] = $user['phone'];
                return TRUE;
            } else {
                $db->rollBack();
                throw new Exception('Ошибка обновления данных пользователя в таблице users_auth');//генерируем исключение
            }
        }
        else {
            throw new Exception('Ошибка обновления данных пользователя в таблице users_all');//генерируем исключение
            //return FALSE;
        }		
	}

    public static function updatePasswordUser ($user) {
        $hash = password_hash($user['password'], PASSWORD_BCRYPT);
        $db = Db::getConnection();
        $query_prep ="UPDATE users_auth
		SET
			hash = :hash
		WHERE id_user = :id_user
		";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->bindValue(':hash', $hash, PDO::PARAM_STR);
        $dbstmt->bindValue(':id_user', $_SESSION['user']['id_user'], PDO::PARAM_INT);
        if ($dbstmt->execute()) {
            $db = NULL;  //Закрываем соединение
            return TRUE;
        }
        else {
            $db = NULL;  //Закрываем соединение
            return FALSE;
        }
    }
	

    public static function startAuthenticatedSession ($user) {
        //session_start();
		
        $_SESSION['user']['id_user'] = $user['id_user'];
        $_SESSION['user']['name'] = $user['name'];
        $_SESSION['user']['email'] = $user['email'];
		$_SESSION['user']['phone'] = $user['phone'];
		
		//$_SESSION['user'] = array ($user['id_user'], $user['name'], $user['email']);
		//$_SESSION['user'] = $user;
    }

    public static function checkAuthenticatedSession () {
        //session_start();
        if (isset($_SESSION['user'])) {
            return true;
        }else {
            header("Location: /user/login");
            exit;
        }
    }
	
	public static function checkGuest () {
		//session_start();
        if (isset($_SESSION['user'])) {
			return false;
		}else {
			return true;
		}		
	}

    public static function checkAdmin () {
        if ($idUser = $_SESSION['user']['id_user']) {
            $db = Db::getConnection();
            $query = "SELECT
                user_status.status
                FROM users_auth
                INNER JOIN user_status
                ON users_auth.status = user_status.id_status
                WHERE users_auth.id_user = $idUser
            ";
            $dbstmt = $db->query($query);
            $result = $dbstmt->fetchColumn();
            $db = NULL;  //Закрываем соединение
            if ($result == 'admin') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function checkAuthUser ($idUser) {

    }
	
	
    // Разрешаем только буквы, цифры, знак подчеркивания, пробелы
    public static function checkName ($string){
        //echo preg_match('/^[a-zA-Zа-яА-ЯёЁ_\d\s]+$/u', trim($string));
		//echo '<br>';
        if ((mb_strlen($string) >= NAME_MIN) && (preg_match('/^[a-zA-Zа-яА-ЯёЁ_\d\s]+$/u', trim($string))==1) && $string==trim($string)) {
            return true;
        }else {
            return false;
        }
    }
	public static function checkPassword ($string){
        //echo preg_match('/^[a-zA-Z_\d]+$/u', trim($string));
		//echo '<br>';
        if ((mb_strlen($string) >= PASSWORD_MIN) && (preg_match('/^[a-zA-Z_\d]+$/u', trim($string))==1) && $string==trim($string)) {
            return true;
        }else {
            return false;
        }
    }
	public static function checkEmail ($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}else {
			return false;
		}
	}

	public static function checkPhone ($phone) {
		 if ((mb_strlen($phone) >= PHONE_MIN) && (preg_match('/^[\d]{9,}$/u', trim($phone))==1) && $phone==trim($phone)) {
            return true;
        }else {
            return false;
        }
	}


	
}