<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці document_resolutions.
 */
class document_resolutions extends DbRecord {

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
				// DbPrefix .'users' => [
				// 	'key_column' => 'id',
				// 	'relation_column' => 'idr_id_user',
				// 	'onDelete' => false
				// ]
			];
		}

		return $this->foreignKeys;
	}
}
