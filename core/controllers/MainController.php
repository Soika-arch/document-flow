<?php

namespace core\controllers;

use core\exceptions\MainException;
use core\Router;

/**
 * Базовий контролер.
 */
class MainController {

	use \core\traits\SetGet;

	private \core\models\MainModel $Model;
	// Масив статусів користувачів, яким дозволено доступ до поточного метода сторінки.
	protected array $allowedStatuses;

	/**
	 *
	 */
	public function __construct () {
		$this->Model = $this->get_Model();
	}

	/**
	 * Ініціалізує та повертає властивість $this->Model.
	 */
	protected function get_Model () {
		if (! isset($this->Model)) {
			$namespaceModels = Modules[Router::getInstance()->moduleURI]['namespaceModels'];
			$modelName = $namespaceModels .'\\'. Router::getInstance()->controllerName .'Model';
			$modelName = str_replace('Controller', '', $modelName);
			$this->Model = new $modelName();
		}

		return $this->Model;
	}

	/**
	 * Сторінка ''.
	 */
	public function mainPage () {
		$d = $this->Model->mainPage();

		require $this->getViewFile('main');
	}

	/**
	 *
	 */
	public function notFoundPage () {
		$d['title'] = 'Сторінка не знайдена';

		require $this->getViewFile('/page_not_found');

		return false;
	}

	/**
	 * Отримання виду.
	 * @param string $viewName ім'я виду файла
	 * @return string
	 */
	protected function getViewFile (string $viewName) {
		if (strpos($viewName, '/') !== 0) {
			$fName = DirViews .'/'. Modules[Router::getInstance()->moduleURI]['dirName'] .'/'.
				$viewName .'.php';
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
		if (! in_array($userStatus, $resolvedStatuses)) return $this->notFoundPage();

		return true;
	}
}
