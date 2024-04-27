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
		$Us = rg_Rg()->get('Us');

		if (! in_array($Us->Status->_name, ['Admin'])) {
			hd_Hd()->addHeader('Location: '. url('/page-not-found'), __FILE__, __LINE__)->send();
			exit;
		}
	}
}
