<?php

namespace core\controllers;

use core\Post;

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
				'pattern' => '^[a-zA-Z0-9_]{5,32}$'
			],
			'password' => [
				'type' => 'varchar',
				'pattern' => '^[a-zA-Z0-9!@#$%^&*()_+=_-]{5,32}$'
			],
			'bt_loging' => [
				'type' => 'varchar',
				'pattern' => '^$'
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
}
