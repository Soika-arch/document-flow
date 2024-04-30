<?php

namespace core\controllers;

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
		$this->checkPageAccess($Us->Status->_name, ['Admin']);

		return require $this->getViewFile('main');
	}
}
