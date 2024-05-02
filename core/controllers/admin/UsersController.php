<?php

namespace core\controllers\admin;

/**
 * Контроллер адмін-панелі управління користувачами.
 */
class UsersController extends AdminController {

	public function __construct () {
		parent::__construct();
	}

	public function mainPage () {
		$d['title'] = 'Адмін-панель - Користувачі';
		$Us = rg_Rg()->get('Us');

		if ($view = $this->checkPageAccess($Us->Status->_name, ['Admin'])) return $view;

		require $this->getViewFile('/admin/users/main');
	}

	public function addPage () {
		$d['title'] = 'Адмін-панель - Додавання користувача';
		$Us = rg_Rg()->get('Us');

		if ($view = $this->checkPageAccess($Us->Status->_name, ['Admin'])) return $view;

		$d = array_merge($d, $this->Model->add());

		require $this->getViewFile('/admin/users/add');
	}
}
