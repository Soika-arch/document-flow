<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці users.
 */
class users extends DbRecord {

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
}
