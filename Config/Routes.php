<?php
// Массив с маршрутами
return array(

	//Просмотр конкретного товара по id
	'~product/([0-9]+)~' => 'product/view/$1', // actionView в ProductController
	
	// Просмотр товаров по категории
	'~category/([0-9]+)/page=([0-9]+)~' => 'site/index/$1/$2', // actionIndex в SiteController с категорией товара и номером страницы пагинации

	// Просмотр товаров по категории
	'~category/([0-9]+)~' => 'site/index/$1', // actionIndex в SiteController с категорией товара

	//Главная страница, просмотр последних добавленных товаров
	'~^$~' => 'site/index', // actionIndex в SiteController
	//Обратная связь
	'~contacts~' => 'site/contacts', // actionContacts в SiteController
	
    // Админка добавление нового товара
    '~admin/product/create~' => 'adminProduct/create',
	 // Админка добавление новой категории товара
    '~admin/category/create~' => 'adminCategory/create',
    // Админка добавление нового брэнда
    '~admin/brand/create~' => 'adminBrand/create',
    // Админка удаление товара
    '~admin/product/delete/([0-9]+)~' => 'adminProduct/delete/$1',
	 // Админка удаление категории
    '~admin/category/delete/([0-9]+)~' => 'adminCategory/delete/$1',
	// Админка удаление брэнда
	'~admin/brand/delete/([0-9]+)~' => 'adminBrand/delete/$1',
	// Админка изменение товара
	'~admin/product/update/([0-9]+)~' => 'adminProduct/update/$1',
	// Админка изменение категории товара
    '~admin/category/update/([0-9]+)~' => 'adminCategory/update/$1',
    // Админка изменение брэнда товара
    '~admin/brand/update/([0-9]+)~' => 'adminBrand/update/$1',
    //Админка список товаров
    '~admin/product/page=([0-9]+)~' => 'adminProduct/index/$1', // actionIndex в AdminProductController
    //Админка список товаров
    '~admin/product~' => 'adminProduct/index', // actionIndex в AdminProductController
	//Админка список категорий
    '~admin/category~' => 'adminCategory/index', // actionIndex в AdminCategoryController
	//Админка список производителей
	'~admin/brand~' => 'adminBrand/index', // actionIndex в AdminBrandController
	//Админка удаление заказов
	'~admin/orders/delete/([0-9]+)~' => 'adminOrders/delete/$1', // actionDelete в AdminOrdersController
    //Админка список заказов
    '~admin/orders/page=([0-9]+)~' => 'adminOrders/index/$1', // actionIndex в AdminOrdersController
    //Админка список заказов
    '~admin/orders~' => 'adminOrders/index', // actionIndex в AdminOrdersController
	// Регистрация пользователей
	'~user/registration~' => 'user/registration', // actionRegistration в UserController
	// Авторизация на сайте
	'~user/login~' => 'user/login', // actionLogin в UserController
	// Выход из авторизации
	'~user/logout~' => 'user/logout', // actionLogin в UserController
	// Корзина добавление товара
    '~cart/add/([0-9]+)~' => 'cart/add/$1', // actionAdd в CartController
	// Корзина удаление товара
    '~cart/delete/([0-9]+)~' => 'cart/delete/$1', // actionDelete в CartController
	// Корзина удаление товара
    '~cart/checkout~' => 'cart/checkout', // actionCheckout в CartController
	// Корзина
    '~cart~' => 'cart/index', // actionIndex в CartController
	
	// Редактирование личных данных пользователя
	'~cabinet/edit~' => 'cabinet/edit', // actionEdit в CabinetController
	// Смена пароля пользователя
	'~cabinet/pass~' => 'cabinet/pass', // actionPass в CabinetController
    // Просмотр заказа пользователем
    '~cabinet/order/([0-9]+)~' => 'cabinet/order/$1', // actionOrder в CabinetController
	// Просмотр заказов пользователя
	'~cabinet/orders~' => 'cabinet/orders', // actionOrders в CabinetController
		// Личный кабинет пользователя
	'~cabinet~' => 'cabinet/index', // actionIndex в CabinetController
	
    // Админка главная страница
	'~admin~' => 'admin/index', // actionIndex в AdminController

);


?>
