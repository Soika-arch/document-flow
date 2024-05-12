<?php

namespace modules\ap\models;

use \modules\ap\models\MainModel;
use \core\Post;
use core\RecordSliceRetriever;
use \core\User;
use libs\Paginator;

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
	 * @param int $pageNum
	 * @return array
	 */
	public function listPage (int $pageNum=1) {
		$SQLUsers = (new RecordSliceRetriever())
			->from('df_users')
			->columns(['us_id', 'us_login'])
			->orderBy('us_id');

		$itemsPerPage = 1;

		$d['users'] = $SQLUsers->select($itemsPerPage, $pageNum);

		$Pagin = new Paginator($SQLUsers->getRowsCount(), 1, 1);

		$d['pagin'] = $Pagin->getPages();

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
