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

		$modelName = NamespaceModels .'\\'. Router::getInstance()->controllerName .'Model';
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

		return require $this->getViewFile('main');
	}

	/**
	 *
	 */
	public function notFoundPage () {
		dd(Router::getInstance(), __FILE__, __LINE__,1);
	}

	/**
	 * Отримання виду.
	 * @return string
	 * @param string $viewName ім'я виду файла
	 */
	protected function getViewFile (string $viewName) {
		if (strpos($viewName, '/') !== 0) {
			$fName = DirViews .'/'. lcfirst(Router::getInstance()->controllerName) .'/'. $viewName .'.php';
		}
		else {
			$fName = DirViews .'/'. $viewName .'.php';
		}

		if (is_file($fName)) return $fName;
		else throw new MainException(1000, ['viewName' => $viewName, 'fname' => $fName, 'this' => $this]);
	}
}
