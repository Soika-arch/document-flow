<?php

namespace modules\ap\controllers;

use core\controllers\MainController as MC;

/**
 * Контроллер адмін-панелі.
 */
class MainController extends MC {

	private \modules\ap\models\MainModel $Model;

	public function __construct () {
		$this->Model = $this->get_Model();
	}

	/**
	 * Ініціалізує та повертає властивість $this->allowedStatuses.
	 */
	private function get_allowedStatuses () {
		if (! isset($this->allowedStatuses)) {
			$this->allowedStatuses = ['SuperAdmin'];
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
