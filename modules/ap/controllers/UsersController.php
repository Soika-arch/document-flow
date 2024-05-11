<?php

namespace modules\ap\controllers;

use core\Get;
use \modules\ap\controllers\MainController;
use \modules\ap\models\UsersModel;
use \core\User;
use \libs\Paginator;

/**
 * Контроллер адмін-панелі управління користувачами.
 */
class UsersController extends MainController {

	private UsersModel $Model;

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

	public function mainPage () {
		$Us = rg_Rg()->get('Us');
		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$d['title'] = 'Адмін-панель - Користувачі';

		require $this->getViewFile('users/main');
	}

	public function addPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		if (isset($_POST['bt_addUser'])) {
			if ($this->Model->addUser()) {
				hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);
			}
		}

		$d['title'] = 'Адмін-панель - Додавання користувача';
		$d = array_merge($d, $this->Model->add());

		require $this->getViewFile('users/add');
	}

	public function listPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'pg' => [
				'type' => 'int',
				'pattern' => '^\d{1,4}$'
			]
		]);

		if ($Get->errors) dd($Get->errors, __FILE__, __LINE__,1);

		// Видалення користувача.
		if (isset($_GET['del_user'])) {
			$UsDeleted = new User($_GET['del_user']);
			$login = $UsDeleted->_login;
			$resDel = $UsDeleted->delete();

			if ($resDel['rowCount']) {
				sess_addSysMessage('Користувача <b>'. $login .'</b> видалено.');
				hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);
			}
		}

		$d['title'] = 'Адмін-панель - Користувачі';
		$d['usersData'] = $this->Model->listPage($Get->get['pg']);

		require $this->getViewFile('users/list');
	}
}
