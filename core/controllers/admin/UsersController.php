<?php

namespace core\controllers\admin;

use core\Header;

/**
 * Контроллер адмін-панелі управління користувачами.
 */
class UsersController extends AdminController {

	public function __construct () {
		parent::__construct();
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

	public function mainPage () {
		$Us = rg_Rg()->get('Us');
		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$d['title'] = 'Адмін-панель - Користувачі';

		require $this->getViewFile('/admin/users/main');
	}

	public function addPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		if (isset($_POST['bt_addUser'])) {
			if ($this->Model->addUser()) {
				Header::getInstance()
					->addHeader('Location: '. url(''), __FILE__, __LINE__)
					->send();
			}
		}

		$d['title'] = 'Адмін-панель - Додавання користувача';
		$d = array_merge($d, $this->Model->add());

		require $this->getViewFile('users/add');
	}

	public function listPage () {
		$Us = rg_Rg()->get('Us');
		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;
		$d['title'] = 'Адмін-панель - Користувачі';
		$d['users'] = $this->Model->selectList();

		require $this->getViewFile('/admin/users/list');
	}
}
