<?php

namespace core\controllers;

use \core\exceptions\MainException;
use \core\Router;

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
			$namespaceModels = str_replace('controllers', 'models', rt_Rt()->namespaceControllers);
			$modelName = $namespaceModels .'\\'. Router::getInstance()->controllerName .'Model';
			$modelName = str_replace('Controller', '', $modelName);
			$this->Model = new $modelName();
		}

		return $this->Model;
	}

	/**
	 * Сторінка '/'.
	 */
	public function mainPage () {
		$d = $this->Model->mainPage();

		require $this->getViewFile('/main');
	}

	/**
	 * Сторінка 'confirmation'.
	 */
	public function confirmationPage () {
		$d = $this->Model->confirmationPage();

		require $this->getViewFile('/confirmation');
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
	 * @return string
	 */
	protected function getViewFile (string $viewName) {
		if (strpos($viewName, '/') !== 0) {
			// Підключення виду поточного модуля.

			$fName = DirModules .'/'. URIModule .'/views/'. $viewName .'.php';
		}
		else {
			// Підключення виду ядра.

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

	/**
	 * Підключення поточного модуля.
	 */
	public function loadModule () {
		if (URIModule) {
			$moduleFile = DirModules .'/'. URIModule .'/load.php';

			if (is_file($moduleFile)) require_once $moduleFile;
		}
	}
}
