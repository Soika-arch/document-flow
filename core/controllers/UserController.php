<?php

namespace core\controllers;

use \core\Get;
use \core\Post;

/**
 * Контролер користувачів.
 */
class UserController extends MainController {

	private \core\models\UserModel $Model;

	public function __construct () {
		parent::__construct();
		$this->Model = $this->get_Model();
	}

	/**
	 * Сторінка створення сесії користувача.
	 */
	public function loginPage () {
		// Якщо відсутні дані форми авторизації користувача - сторінка не знайдена.
		if (! isset($_POST['bt_loging'])) $this->notFoundPage();

		$Post = new Post('bt_loging', [
			'login' => [
				'type' => 'varchar',
				'pattern' => '^[a-zA-Z0-9_]{5,32}$',
				'isRequired' => true
			],
			'password' => [
				'type' => 'varchar',
				'pattern' => '^[a-zA-Z0-9!@#$%^&*()_+=_-]{5,32}$',
				'isRequired' => true
			],
			'bt_loging' => [
				'type' => 'varchar',
				'pattern' => '^$',
				'isRequired' => true
			]
		]);

		if ($Post->errors) dd($Post->errors, __FILE__, __LINE__,1);

		if (! $this->Model->login($Post)) {
			sess_addErrMessage('Користувача не знайдено або введено неправильний пароль.');
		}

		hd_sendHeader('Location: '. url('/'), __FILE__, __LINE__);
	}

	/**
	 * Сторінка завершення сесії користувача.
	 */
	public function logoutPage () {
		if ($this->Model->logout()) hd_sendHeader('Location: '. url('/'), __FILE__, __LINE__);
	}

	/**
	 * Сторінка профіля користувача.
	 */
	public function profilePage () {
		$Us = rg_Rg()->get('Us');

		$Get = new Get([
			'l' => [
				'type' => 'varchar',
				'pattern' => '^[a-zA-Z0-9_]{5,32}$',
				'isRequired' => true
			]
		]);

		if (! $this->checkPageAccess($Us->Status->_name, ['Viewer', 'User', 'Admin', 'SuperAdmin'])) {

			return;
		}

		$d = $this->Model->profilePage();

		require $this->getViewFile('/user/profile');
	}
}
