<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці document_types.
 */
class document_types extends DbRecord {

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
				// DbPrefix .'visitor_routes' => [
				// 	'key_column' => 'id',
				// 	'relation_column' => 'vr_id_user',
				// 	'onDelete' => true
				// ]
			];
		}

		return $this->foreignKeys;
	}
}
