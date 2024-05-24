<?php

namespace modules\ap\models;

use core\Get;
use \modules\ap\models\MainModel;
use \core\Post;
use \core\RecordSliceRetriever;
use \core\User;
use \libs\Paginator;

/**
 * Модель адмін-панелі управління користувачами.
 */
class UsersModel extends MainModel {

	/**
	 *
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * @return array
	 */
	public function mainPage () {
		$d['title'] = 'Адмін-панель - Користувачі';

		return $d;
	}

	/**
	 *
	 */
	public function add () {
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

		$UserNew = (new User(null))->set([
			'us_login' => $login,
			'us_password_hash' => password_hash($Post->post['password'], PASSWORD_DEFAULT),
			'us_email' => $Post->post['email'],
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
	public function editPage (Get $Get) {
		$d['title'] = 'Адмін-панель - зміна даних користувача';
		$d['statuses'] = $this->getUserStatuses();
		$d['User'] = new User($Get->get['id']);

		return $d;
	}

	/**
	 * @return User
	 */
	public function editUser (Get $Get, Post $Post) {
		$UsEdit = new User($Get->get['id']);
		$post = $Post->post;

		$UsEdit->update([
			'us_login' => getArrayValue($post, 'login'),
			'us_email' => getArrayValue($post, 'email')
		]);

		$UsEdit->setStatus(getArrayValue($post, 'status', 4));

		return $UsEdit;
	}

	/**
	 * @param int $pageNum
	 * @return array
	 */
	public function listPage (int $pageNum=1) {
		$d['title'] = 'Адмін-панель - Користувачі';

		$SQLUsers = (new RecordSliceRetriever())
			->from('df_users')
			->columns(['df_users.*'])
			->orderBy('us_add_date');

		$itemsPerPage = 5;

		$d['users'] = $SQLUsers->select($itemsPerPage, $pageNum);

		$url = url('/ap/users/list?pg=(:num)');

		$Pagin = new Paginator($SQLUsers->getRowsCount(), $itemsPerPage, $pageNum, $url);

		$d['Pagin'] = $Pagin;

		return $d;
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
