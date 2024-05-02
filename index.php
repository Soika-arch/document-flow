<?php

use core\exceptions\ClassException;
use core\exceptions\DbException;
use core\Registry;
use core\Router;
use core\User;

try {

	require_once 'configs/main.php';

	startApp();

	$HTML = '';

	// id користувача або береться з сесії, або буде 0.
	$idUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;

	// Створення об'єкта глобального користувача і збереження його в єдиний глобальний реєстр.
	Registry::getInstance()->add('Us', (new User($idUser))->createVR());

	// Створення об'єкта Router.
	$Router = Router::getInstance();

	// Отримання назви класу контролера.
	$controllerClass = $Router->controllerClass;

	// Отримання назви метода сторінки контролера.
	$controllerMethod = $Router->pageMethod;

	// Створення об'єкта контролера.
	$Controller = new $controllerClass();
	// Виклик метода сторінки контролера.

	// Якщо URLPath має зайвий текст - викликається $Controller->notFoundPage().
	if (Router::getInstance()->isExtraLineInURLPath) {
		$Controller->notFoundPage();
	}
	else {
		$Controller->$controllerMethod();
	}

	handleSessionExpiration();

	// Отримання поточного об'єкта visitor_routes глобального користувача та оновлення даних поточного
	// запису таблиці visitor_routes.
	Registry::getInstance()->get('Us')->upVR();

	if (Debug) require DirViews .'/inc/footer_debug_info.php';

	// Вивід отриманого HTML-кода сторінки.
	echo $HTML;

} catch (ClassException $th) {
	dd($th, __FILE__, __LINE__,1);
} catch (\Exception $th) {
	dd($th, __FILE__, __LINE__,1);
} catch (DbException $th) {
	dd($th, __FILE__, __LINE__,1);
}
catch (\Throwable $th) {
	dd($th, __FILE__, __LINE__,1);
	// echo '<pre>';
	// var_dump($th);
}
