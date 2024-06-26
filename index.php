<?php

use \core\controllers\CronController;
use \core\exceptions\ClassException;
use \core\exceptions\DbException;
use \core\User;

try {

	require_once 'configs/main.php';
	require_once DirRoot .'/libs/autoload.php';

	classesAutoload();
	startApp();

	/** @var int id користувача або береться з сесії, або буде 0 */
	$idUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;

	// Створення об'єкта глобального користувача і збереження його в єдиний глобальний реєстр.
	rg_Rg()->add('Us', (new User($idUser))->createVR());

	/** @var string поточний HTML-код сторінки. */
	$HTML = '';

	if (isCron()) {
		// Cron.

		(new CronController())->run();
	}
	else {
		// Інший користувач.

		/** @var string назва класу контролера. */
		$controllerClass = rt_Rt()->controllerClass;
		/** @var string назва метода сторінки контролера. */
		$controllerMethod = rt_Rt()->pageMethod;

		/** @var \core\controllers\MainController поточний об'єкт контролера. */
		$Controller = new $controllerClass();
		$Controller->loadModule();

		if (rt_Rt()->isExtraLineInURLPath) {
			// Якщо URLPath має зайвий текст - викликається $Controller->notFoundPage().
			$Controller->notFoundPage();
		}
		else {
			// Виклик метода сторінки контролера.
			$Controller->$controllerMethod();
		}
	}

	handleSessionExpiration();

	// Отримання поточного об'єкта visitor_routes глобального користувача та оновлення даних поточного
	// запису таблиці visitor_routes.
	rg_Rg()->get('Us')->upVR();

	if (Debug) require DirViews .'/inc/footer_debug_info.php';

	// Вивід отриманого HTML-кода сторінки.
	echo $HTML;

} catch (ClassException $th) {
	dd($th, __FILE__, __LINE__,1);
} catch (\Exception $th) {
	dd($th, __FILE__, __LINE__,1);
} catch (DbException $th) {
	dd($th, __FILE__, __LINE__,1);
} catch (\Throwable $th) {
	dd($th, __FILE__, __LINE__,1);
	// echo '<pre>';
	// var_dump($th);
}
