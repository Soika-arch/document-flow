<?php

namespace core\controllers\admin;

use core\controllers\MainController;

/**
 * Контроллер адмін-панелі.
 */
class AdminController extends MainController {

	private \core\models\admin\AdminModel $Model;

	public function __construct () {
		$this->Model = $this->get_Model();
	}

	/**
	 * Ініціалізує та повертає властивість $this->allowedStatuses.
	 */
	private function get_allowedStatuses () {
		if (! isset($this->allowedStatuses)) {
			$this->allowedStatuses = ['Admin'];
		}

		return $this->allowedStatuses;
	}

	/**
	 *
	 */
	public function mainPage () {
		$d['title'] = 'Адмін-панель';
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		require $this->getViewFile('main');
	}
}
