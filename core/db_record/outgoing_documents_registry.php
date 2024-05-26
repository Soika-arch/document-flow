<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці outgoing_documents_registry.
 */
class outgoing_documents_registry extends DfDocument {

	protected incoming_documents_registry|null $IncomingDocument;

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		$this->displayedNumberPrefix = 'OUT_';
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
					'relation_column' => 'odr_id_user',
					'onDelete' => false
				]
			];
		}

		return $this->foreignKeys;
	}

	/**
	 * @return incoming_documents_registry|null
	 */
	protected function get_IncomingDocument () {
		if (! isset($this->IncomingDocument)) {
			if ($this->_id_incoming_number) {
				$this->IncomingDocument = new incoming_documents_registry($this->_id_incoming_number);
			}
			else {
				$this->IncomingDocument = null;
			}
		}

		return $this->IncomingDocument;
	}
}
