<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці internal_documents_registry.
 */
class internal_documents_registry extends DfDocument {

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		$this->displayedNumberPrefix = 'INT_';
		parent::__construct($id, $dbRow);
	}

	/**
	 * PHPDoc у класі DbRecord.
	 */
	protected function get_foreignKeys () {
		if (! isset($this->foreignKeys)) {
			$this->foreignKeys = [
				DbPrefix .'users' => [
					'key_column' => 'id',
					'relation_column' => 'inr_id_user',
					'onDelete' => false
				]
			];
		}

		return $this->foreignKeys;
	}
}
