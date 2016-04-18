<?php
class UserModel {

	public static function checkFormRegistration () {
		
		$error = array();
		$user = $_POST['user'];
		//echo "<pre>";
        //print_r ($user);
        //echo "</pre>";
		if (!empty($user['phone'])) {
			//echo "Телефон есть<br>";
			if (!self::checkPhone($user['phone'])) {
            $error[] = 'Неверный телефон';
        }
		} else {
			//echo "Телефона нет<br>";
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
		if (!empty($user['phone'])) {
			//echo "Телефон есть<br>";
			if (!self::checkPhone($user['phone'])) {
            $error[] = 'Неверный телефон';
			}
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
	    echo $email.'<br>' ;
	    $db = Db::getConnection();
	    $query_prep ="SELECT
	    COUNT(*)
	    FROM users
	    WHERE users.email = :email
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
	    users.id_user,
	    users.email,
		users.phone,
	    users.name,
	    users.hash
	    FROM users
	    WHERE users.email = :email
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
        $hash = password_hash($newUser['password'], PASSWORD_BCRYPT);
        $db = Db::getConnection();
        $query_prep ="INSERT INTO users
		(name, email, hash, phone)
		VALUES
		(:name, :email, :hash, :phone)
		";
        $dbstmt = $db->prepare($query_prep);
        $dbstmt->bindValue(':name', $newUser['name'], PDO::PARAM_STR);
        $dbstmt->bindValue(':email', $newUser['email'], PDO::PARAM_STR);
		if (!empty($newUser['phone'])) { // если телефон ввели
			$dbstmt->bindValue(':phone', $newUser['phone'], PDO::PARAM_INT); // определяем данные для ввода телефона
		} else {
			$dbstmt->bindValue(':phone', NULL, PDO::PARAM_STR); // Иначе присваиваем пустое значение
		}		
        $dbstmt->bindValue(':hash', $hash, PDO::PARAM_STR);
        if ($dbstmt->execute()) {
            $db = NULL;  //Закрываем соединение
            return TRUE;
        }
        else {
            return FALSE;
        }

    }
	
	public static function updateUser ($user) {
		$db = Db::getConnection();
		$query_prep ="UPDATE users
		SET
			name = :name,
			phone = :phone,
			email = :email
		WHERE id_user = :id_user
		";
		$dbstmt = $db->prepare($query_prep);
		$dbstmt->bindValue(':email', $user['email'], PDO::PARAM_STR);
		$dbstmt->bindValue(':name', $user['name'], PDO::PARAM_STR);
		if (!empty($user['phone'])) { // если телефон ввели
			$dbstmt->bindValue(':phone', $user['phone'], PDO::PARAM_INT); // определяем данные для ввода телефона
		} else {
			$dbstmt->bindValue(':phone', NULL, PDO::PARAM_STR); // Иначе присваиваем пустое значение
		}	
		
		$dbstmt->bindValue(':id_user', $_SESSION['user']['id_user'], PDO::PARAM_INT);
		if ($dbstmt->execute()) {
            $db = NULL;  //Закрываем соединение
			$_SESSION['user']['name'] = $user['name'];
			$_SESSION['user']['email'] = $user['email'];
			$_SESSION['user']['phone'] = $user['phone'];
            return TRUE;
        }
        else {
            return FALSE;
        }		
	}

    public static function updatePassUser ($user) {
        $hash = password_hash($user['password'], PASSWORD_BCRYPT);
        $db = Db::getConnection();
        $query_prep ="UPDATE users
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
		 if ((mb_strlen($phone) >= PHONE_MIN) && (preg_match('/^[\d]{9}$/u', trim($phone))==1) && $phone==trim($phone)) {
            return true;
        }else {
            return false;
        }
	}
	
}