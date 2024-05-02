<?php

namespace core\controllers;

use core\exceptions\MainException;
use core\Router;

/**
 * Базовий контролер.
 */
class MainController {

	use \core\traits\SetGet;

	protected \core\models\MainModel $Model;

	/**
	 *
	 */
	public function __construct () {
		// Створення відповідної контролеру моделі.
		$namespaceModels = Modules[Router::getInstance()->moduleURI]['namespaceModels'];
		$modelName = $namespaceModels .'\\'. Router::getInstance()->controllerName .'Model';
		$modelName = str_replace('Controller', '', $modelName);
		$this->Model = new $modelName();
	}

	/**
	 * Сторінка ''.
	 */
	public function mainPage () {
		$d = $this->Model->getMain();

		if (isset($_SESSION['errors'])) {
			$d['errors'][] = 'Користувача не знайдено або неправильно введено пароль';
		}

		require $this->getViewFile('main');
	}

	/**
	 *
	 */
	public function notFoundPage () {
		$d['title'] = 'Сторінка не знайдена';

		require $this->getViewFile('/page_not_found');
	}

	/**
	 * Отримання виду.
	 * @param string $viewName ім'я виду файла
	 */
	protected function getViewFile (string $viewName): string {
		if (strpos($viewName, '/') !== 0) {
			$fName = Modules[Router::getInstance()->moduleURI]['dirName'] .'/'. $viewName .'.php';
			$fName = DirViews .'/'. str_replace(['Controller', '-'], ['', '/'], $fName);
		}
		else {
			$fName = DirViews .'/'. $viewName .'.php';
		}

		$fName = str_replace('//', '/', $fName);

		if (is_file($fName)) return $fName;
		else throw new MainException(1000, ['viewName' => $viewName, 'fname' => $fName, 'this' => $this]);
	}

	/**
	 * Перевірка доступу користувача до поточної сторінки.
	 */
	protected function checkPageAccess (string $userStatus, array $resolvedStatuses) {
		if (! in_array($userStatus, $resolvedStatuses)) $this->notFoundPage();
	}
}
