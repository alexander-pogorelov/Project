<?php

class Router {

	private $routes; //массив с маршрутами

	public function __construct(){
        $routesPath = ROOT . '/Config/Routes.php'; // Путь к файлу с маршрутами
        $this->routes = include($routesPath); // Получаем маршруты из файла
	}
	// Функция получения строки запроса
	private function getURI(){
		if (!empty($_SERVER['REQUEST_URI'])) {
			//echo "URI<br>";
			//echo $_SERVER['REQUEST_URI'];
			//echo "<br>";
			return strtolower(trim($_SERVER['REQUEST_URI'], '/')); // Удаляем / из строки запроса
		}
	}
	//Главная функция
	public function run(){
		try {
			//echo "Старт роутера<hr>";
			$uri=$this->getURI();
			//echo "адресная строка: <br>";
			//echo "($uri)<hr>";
			$i=1; // Счетчик цикла поиска маршрута
			// Цикл проверки совпадения строки запроса с заданными паттернами маршрутов
			foreach ($this->routes as $uriPattern => $path) {
				//echo "Маршрут ($uriPattern) => $path<br>";
				//echo 'Итерация: '.$i.'<br>';
				//$uriPattern='~'.$uriPattern.'~';
				if (preg_match($uriPattern, $uri)){// СОВПАДЕНИЕ ТАКЖЕ  НАХОДИТСЯ, ЕСЛИ КЛЮЧЕВОЕ СЛОВО НАДОДИТСЯ НЕ СНАЧАЛА URI
					//echo "Совпадение!<hr>";
					// получаем внутренний маршрут вида контроллер/экшен/параметры
					$internalRoute = preg_replace($uriPattern, $path, $uri); // заменяем строку запроса на внутренний маршрут из массива маршрутов, параметры из строки вставляются вместо $1 и $2
					//echo "Внутренний маршрут: $internalRoute<br>";
					$segments = explode('/', $internalRoute); // разбиваем строку по / и заносим в массив
					$controllerName = array_shift($segments) . 'Controller'; // вырезаем первый элемент из массива и получаем имя контроллера
					$controllerName = ucfirst($controllerName); // первую букву в названии контроллера делаем заглавной
						//echo "Имя контроллера (класс): $controllerName<br>";
					$actionName = 'action' . ucfirst(array_shift($segments)); // вырезаем второй элемент из остатка массива и получаем имя экшена
						//echo "Имя экшена (метод): $actionName<hr>";
					$parameters = $segments;
						//echo "Параметры: <br>";
						//var_dump ($parameters);
					$controller = new $controllerName(); // создаем объект нужного контролера
                    // Вызываем метод $controller->actionName() с передачей массива аргументов
					$result = call_user_func_array(array($controller, $actionName), $parameters);
                    //echo $result;
					if ($result) {// если нужный метод нужного контроллера найден - прерываем цикл поиска
						//echo "<hr>Найдено совпадение<hr>";
						break;
					}
				}
                $i++;
			}
            //echo "<hr>$i<hr><hr>";
            //Если счетчик итераций больше числа маршрутов и нет совпадения - страница не найдена
            if ($i > count($this->routes)) {
                (new SiteController())->error404();
            }
		}
		catch(Exception $e) {
			echo 'ОШИБКА<br/>' . $e->getMessage();//если возникла ошибка, выводим сообщение
		}
	}
}
