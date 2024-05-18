<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці incoming_documents_registry.
 */
class incoming_documents_registry extends DbRecord {

	protected document_titles $DocumentTitle;

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
				DbPrefix .'users' => [
					'key_column' => 'id',
					'relation_column' => 'idr_id_user',
					'onDelete' => false
				]
			];
		}

		return $this->foreignKeys;
	}

	/**
	 * @return document_titles
	 */
	protected function get_DocumentTitle () {
		if (! isset($this->DocumentTitle)) {
			$this->DocumentTitle = new document_titles($this->_id_title);
		}

		return $this->DocumentTitle;
	}
}
