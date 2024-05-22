<?php

namespace modules\ap\controllers;

use \core\Get;
use \modules\ap\controllers\MainController;
use \modules\ap\models\UsersModel;
use \core\User;

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
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'del_user' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'confirm' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(y|n)$'
			]
		]);

		if ($Get->errors) dd($Get->errors, __FILE__, __LINE__,1);

		// Видалення користувача.
		if (isset($_GET['del_user'])) {
			$UsDeleted = new User($_GET['del_user']);

			if (isset($Get->get['confirm']) && ($Get->get['confirm'] === 'y')) {
				$login = $UsDeleted->_login;
				$resDel = $UsDeleted->delete();

				if ($resDel['rowCount']) {
					sess_addSysMessage('Користувача <b>'. $login .'</b> видалено.');
					hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);
				}
			}

			unset($get['del_user']);

			sess_addConfirmData([
				'question' => 'Видалити користувача [ <b>'. $UsDeleted->_login .'</b> ] ?',
				'sourceURL' => URL,
				'paramsForDeletion' => ['del_user']
			]);

			hd_sendHeader('Location: '. url('/confirmation'), __FILE__, __LINE__);
		}

		$d['title'] = 'Адмін-панель - Користувачі';

		$pageNum = isset($Get->get['pg']) ? $Get->get['pg'] : 1;

		$d['usersData'] = $this->Model->listPage($pageNum);

		require $this->getViewFile('users/list');
	}
}
