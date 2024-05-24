<?php

namespace modules\ap\controllers;

use \core\Get;
use \core\Post;
use \core\User;
use \modules\ap\controllers\MainController;
use \modules\ap\models\UsersModel;

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

		$d = $this->Model->mainPage();

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

	public function editPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'id' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,5}$'
			]
		]);

		if (isset($_POST['bt_editUser'])) {
			$Post = new Post('bt_editUser', [
				'login' => [
					'type' => 'varchar',
					'isRequired' => true,
					'pattern' => '^[a-zA-Z0-9_]{5,32}$'
				],
				'email' => [
					'type' => 'varchar',
					'isRequired' => true,
					'pattern' => '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
				],
				'status' => [
					'type' => 'int',
					'isRequired' => true,
					'pattern' => '^\d{1,2}$'
				],
				'bt_editUser' => [
					'type' => 'varchar',
					'isRequired' => true,
					'pattern' => '^$'
				]
			]);

			if ($Post->errors) dd($Post->errors, __FILE__, __LINE__,1);

			$UsEdit = $this->Model->editUser($Get, $Post);

			if ($UsEdit) {
				sess_addSysMessage('Дані збережено.');
				hd_sendHeader('Location: '. url('/ap/users/edit?id='. $UsEdit->_id), __FILE__, __LINE__);
			}
		}

		$d['title'] = 'Адмін-панель - Додавання користувача';
		$d = $this->Model->editPage($Get);

		require $this->getViewFile('users/edit');
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

		$pageNum = isset($Get->get['pg']) ? $Get->get['pg'] : 1;

		$d = $this->Model->listPage($pageNum);

		require $this->getViewFile('users/list');
	}
}
