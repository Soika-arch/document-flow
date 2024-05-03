<?php

namespace core\models\admin;

use core\models\admin\AdminModel;
use core\Post;
use core\User;

/**
 * Модель адмін-панелі управління користувачами.
 */
class UsersModel extends AdminModel {

	/**
	 *
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 *
	 */
	public function add () {
		$d = [];

		$d['statuses'] = $this->getUserStatuses();

		return $d;
	}

	/**
	 * Обробка спроби додавання нового користувача в БД.
	 * @return bool
	 */
	public function addUser () {
		$Post = new Post('fm_userAdd', [
			'login' => [
				'type' => 'varchar',
				'pattern' => '^[a-zA-Z0-9_]{5,32}$'
			],
			'password' => [
				'type' => 'varchar',
				'pattern' => '^[a-zA-Z0-9!@#$%^&*()_+=_-]{5,32}$'
			],
			'email' => [
				'type' => 'varchar',
				'pattern' => '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
			],
			'status' => [
				'type' => 'int'
			],
			'bt_addUser' => [
				'type' => 'varchar',
				'pattern' => '^$'
			]
		]);

		if ($Post->errors) dd($Post, __FILE__, __LINE__,1);

		$login = $Post->sanitizeValue('login');

		$UserNew = (new User(0))->set([
			'us_login' => $login,
			'us_password_hash' => password_hash($Post->post['password'], PASSWORD_DEFAULT),
			'us_add_date' => date('Y-m-d H:i:s')
		]);

		if ($UserNew->_id) {
			sess_addSysMessage('Створено нового користувача <b>'. $login .'</b>.');

			if ($UserNew->setStatus($Post->sanitizeValue('status'))) {
				sess_addSysMessage('Користувачу <b>'. $login .'</b> призначено статус <b>'.
					$UserNew->Status->_name .'</b>.');
			}
		}

		return true;
	}

	/**
	 * @return array
	 */
	public function selectList () {
		$SQL = db_getSelect();

		$SQL
			->columns(['*'])
			->from(DbPrefix .'users');

		return db_select($SQL);
	}

	/**
	 * Отримання таблиці user_statuses (усіх статусів користувачів).
	 * @return array
	 */
	public function getUserStatuses () {
		$SQL = db_getSelect();

		$SQL
			->columns(['*'])
			->from(DbPrefix .'user_statuses');

		return db_select($SQL);
	}
}
