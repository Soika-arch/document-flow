<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці outgoing_documents_registry.
 */
class outgoing_documents_registry extends DfDocument {

	// Відправник користувач.
	protected users $Sender;
	// Отримувач зовнішній.
	protected document_senders $Recipient;
	protected incoming_documents_registry $IncomingDocument;

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
	 * @return incoming_documents_registry
	 */
	protected function get_IncomingDocument () {
		if (! isset($this->IncomingDocument)) {
			$idIncomingNumber = $this->_id_incoming_number ? $this->_id_incoming_number : null;

			$this->IncomingDocument = new incoming_documents_registry($idIncomingNumber);
		}

		return $this->IncomingDocument;
	}

	/**
	 * @return users
	 */
	protected function get_Sender () {
		if (! isset($this->Sender)) {
			$idSender = $this->_id_sender ? $this->_id_sender : null;

			$this->Sender = new users($idSender);
		}

		return $this->Sender;
	}

	/**
	 * @return document_senders
	 */
	protected function get_Recipient () {
		if (! isset($this->Recipient)) {
			$idRecipient = $this->_id_recipient ? $this->_id_recipient : null;

			$this->Recipient = new document_senders($this->_id_recipient);
		}

		return $this->Recipient;
	}
}
