<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці users.
 */
class users extends DbRecord {

	// Зв'язок користувача з його статусом.
	protected users_rel_statuses|null $UserRelStatus;
	// Статус користувача.
	protected user_statuses $Status;

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		parent::__construct($id, $dbRow);
	}

	/**
	 * PHPDoc у класі DbRecord.
	 */
	protected function get_foreignKeys () {
		if (! isset($this->foreignKeys)) {
			$this->foreignKeys = [
				DbPrefix .'visitor_routes' => [
					'key_column' => 'id',
					'relation_column' => 'vr_id_user',
					'onDelete' => true
				],
				DbPrefix .'users_rel_statuses' => [
					'key_column' => 'id',
					'relation_column' => 'usr_id_user',
					'onDelete' => true
				],
				DbPrefix .'user_rel_departament' => [
					'key_column' => 'id',
					'relation_column' => 'urd_id_user',
					'onDelete' => true
				]
			];
		}

		return $this->foreignKeys;
	}

	/**
	 * @return users_rel_statuses
	 */
	protected function get_UserRelStatus () {
		if (! isset($this->UserRelStatus)) {
			$SQL = db_getSelect();
			$tName = DbPrefix .'users_rel_statuses';

			$SQL
				->columns([$tName .'.*'])
				->from($tName)
				->join(DbPrefix .'users', 'us_id', '=', 'usr_id_user')
				->where('us_id', '=', $this->_id);

			$row = db_selectRow($SQL);

			if ($row) {
				$this->UserRelStatus = new users_rel_statuses($row['usr_id'], $row);
			}
			else {
				$this->UserRelStatus = null;
			}
		}

		return $this->UserRelStatus;
	}

	/**
	 * @return user_statuses
	 */
	protected function get_Status () {
		if ($this->get_UserRelStatus()) $this->Status = $this->get_UserRelStatus()->UserStatus;

		return $this->Status;
	}
}
