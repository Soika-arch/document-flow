<?php

namespace core;

use core\db_record\user_statuses;
use core\db_record\users_rel_statuses;

class UserRelStatus extends users_rel_statuses {

	// Статус користувача. Користувач може мати тільки один статус, наприклад статус 'Admin'.
	// Статус користувача обумовлює рівень доступу до адміністративних можливостей застосунка.
	private user_statuses $UserStatus;

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		parent::__construct($id, $dbRow);
	}

	/**
	 * @return user_statuses
	 */
	protected function get_UserStatus () {
		if (! isset($this->UserStatus)) {
			$SQL = db_getSelect();
			$tName = DbPrefix .'user_statuses';

			$SQL
				->columns([$tName .'.*'])
				->from($tName)
				->join(DbPrefix .'users_rel_statuses', 'usr_id_status', '=', 'uss_id')
				->where('usr_id', '=', $this->_id);

			$row = db_selectRow($SQL);

			$this->UserStatus = new user_statuses($row['uss_id'], $row);
		}

		return $this->UserStatus;
	}
}
