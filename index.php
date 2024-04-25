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
	dd(Registry::getInstance()->get('Us')->UserRelStatus->UserStatus->_name, __FILE__, __LINE__);
	// Створення об'єкта Router.
	$Router = Router::getInstance();

	// Отримання назви класу контролера.
	$controllerClass = $Router->controllerClass;
	// Отримання назви метода сторінки контролера.
	$controllerMethod = $Router->pageName;

	// Створення об'єкта контролера.
	$Controller = new $controllerClass();
	// Виклик метода сторінки контролера.
	$Controller->$controllerMethod();

	handleSessionExpiration();

	// Час завершення виконання скрипта програми в секундах з точністю до стотисячних.
	$exMktEnd = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 5);

	// Отримання поточного об'єкта visitor_routes глобального користувача та оновлення даних поточного
	// запису таблиці visitor_routes.
	Registry::getInstance()->get('Us')->upVR($exMktEnd);

	if (Debug) require DirViews .'/inc/footer_debug_info.php';

	// Вивід отриманого HTML-кода сторінки.
	echo $HTML;

} catch (ClassException $th) {
	$th->printMsg();
} catch (\Exception $th) {
	dd($th, __FILE__, __LINE__,1);
} catch (DbException $th) {
	dd($th, __FILE__, __LINE__,1);
}
catch (\Throwable $th) {
	dd($th, __FILE__, __LINE__,1);
}
