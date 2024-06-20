<?php

namespace modules\ap\models;

use \core\Get;
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
		$Post = rg_Rg()->get('Post');

		$login = $Post->sanitizeValue('login');
		$tgId = (isset($Post->post['tgId']) && $Post->post['tgId']) ? $Post->post['tgId'] : null;

		$UserNew = (new User(null))->set([
			'us_login' => $login,
			'us_password_hash' => password_hash($Post->post['password'], PASSWORD_DEFAULT),
			'us_email' => $Post->post['email'],
			'us_id_tg' => $tgId,
			'us_add_date' => date('Y-m-d H:i:s')
		]);

		if ($UserNew->_id) {
			$profileURL = url('/user/profile?l='. $login);
			$profileLink = '<a href="'. $profileURL .'">'. $login .'</a>';
			sess_addSysMessage('Створено нового користувача <b>'. $profileLink .'</b>.');

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
			'us_email' => getArrayValue($post, 'email'),
			'us_id_tg' => getArrayValue($post, 'tgId')
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
		$tName = DbPrefix .'users';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->orderBy('us_add_date', 'desc');

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['users'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/ap/users/list?pg=(:num)#pagin');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
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
