<?php

namespace core\controllers;

/**
 * Контроллер адмін-панелі управління користувачами.
 */
class AdminUsersController extends AdminController {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *
	 */
	public function mainPage () {
		$d['title'] = 'Адмін-панель - Користувачі';
		$Us = rg_Rg()->get('Us');

		if ($view = $this->checkPageAccess($Us->Status->_name, ['Admin'])) return $view;

		return require $this->getViewFile('main');
	}
}
