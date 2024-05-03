<?php

namespace core\controllers;

use core\Post;

/**
 * Контролер користувачів.
 */
class UserController extends MainController {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *
	 */
	public function mainPage () {
		dd(__METHOD__, __FILE__, __LINE__,1);
	}

	/**
	 *
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

		$this->Model->login($Post);
	}

	/**
	 *
	 */
	public function logoutPage () {
		$this->Model->logout();
	}

	/**
	 *
	 */
	public function addPage () {
		dd(__METHOD__, __FILE__, __LINE__,1);
	}
}
