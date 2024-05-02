<?php

namespace core\models\admin;

use core\models\admin\AdminModel;

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
	 * Отримання таблиці user_statuses (усіх статусів користувачів).
	 */
	public function getUserStatuses (): array {
		$SQL = db_getSelect();

		$SQL
			->columns(['*'])
			->from(DbPrefix .'user_statuses');

		return db_select($SQL);
	}
}
