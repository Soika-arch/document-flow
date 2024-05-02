<?php

namespace core\controllers\admin;

use core\controllers\MainController;

/**
 * Контроллер адмін-панелі.
 */
class AdminController extends MainController {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *
	 */
	public function mainPage () {
		$d['title'] = 'Адмін-панель';
		$Us = rg_Rg()->get('Us');

		if ($view = $this->checkPageAccess($Us->Status->_name, ['Admin'])) return $view;

		require $this->getViewFile('main');
	}
}
