<?php

namespace modules\df\models;

use \core\models\MainModel as MM;
use \core\Post;
use \core\RecordSliceRetriever;
use \core\User;
use \libs\Paginator;

/**
 * Модель типів документів.
 */
class MainModel extends MM {

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
		dd($d, __FILE__, __LINE__,1);
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
		$SQLDt = (new RecordSliceRetriever())
			->from(DbPrefix .'document_types')
			->columns(['dt_id', 'dt_name'])
			->orderBy('dt_id');

		$itemsPerPage = 2;

		$d['dt'] = $SQLDt->select($itemsPerPage, $pageNum);

		$Pagin = new Paginator($SQLDt->getRowsCount(), $itemsPerPage, 1);

		$d['pagin'] = $Pagin->getPages();

		return $d;
	}
}
