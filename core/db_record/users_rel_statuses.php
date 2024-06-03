<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці users_rel_statuses.
 */
class users_rel_statuses extends DbRecord {

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
	public function get_UserStatus () {
		if (! isset($this->UserStatus)) {
			$SQL = db_getSelect();
			$tName = DbPrefix .'user_statuses';

			$SQL
				->columns([$tName .'.*'])
				->from($tName)
				->join(DbPrefix .'users_rel_statuses', 'usr_id_status', '=', 'uss_id')
				->where('usr_id', '=', $this->_id);

			$row = db_selectRow($SQL);

			$ussId = isset($row['uss_id']) ? $row['uss_id'] : null;

			$this->UserStatus = new user_statuses($ussId, $row);
		}

		return $this->UserStatus;
	}
}
