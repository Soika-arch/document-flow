<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці incoming_documents_registry.
 */
class incoming_documents_registry extends DfDocument {

	// Відправник зовнішній.
	protected document_senders|null $Sender;
	// Отримувач користувач.
	protected users|null $Recipient;
	protected outgoing_documents_registry|null $OutgoingDocument;
	// Відповідальний за виконання.
	protected users|null $ResponsibleUser;
	// Відділ який відповідає за виконання.
	protected departments|null $ResponsibleDepartament;

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		$this->displayedNumberPrefix = 'INC_';
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
	 * @return outgoing_documents_registry|null
	 */
	protected function get_OutgoingDocument () {
		if (! isset($this->OutgoingDocument)) {
			if ($this->_id_outgoing_number) {
				$this->OutgoingDocument = new outgoing_documents_registry($this->_id_outgoing_number);
			}
			else {
				$this->OutgoingDocument = null;
			}
		}

		return $this->OutgoingDocument;
	}

	/**
	 * @return document_senders
	 */
	protected function get_Sender () {
		if (! isset($this->Sender) && $this->_id_sender) {
			$this->Sender = new document_senders($this->_id_sender);
		}
		else {
			$this->Sender = null;
		}

		return $this->Sender;
	}

	/**
	 * @return users
	 */
	protected function get_Recipient () {
		if (! isset($this->Recipient)) {
			if ($this->_id_recipient) {
				$this->Recipient = new users($this->_id_recipient);
			}
			else {
				$this->Recipient = null;
			}
		}

		return $this->Recipient;
	}

	/**
	 * @return users
	 */
	protected function get_ResponsibleUser () {
		if (! isset($this->ResponsibleUser)) {
			if ($this->_id_responsible_user) {
				$this->ResponsibleUser = new users($this->_id_responsible_user);
			}
			else {
				$this->ResponsibleUser = null;
			}
		}

		return $this->ResponsibleUser;
	}

	/**
	 * @return departments
	 */
	protected function get_ResponsibleDepartament () {
		if (! isset($this->ResponsibleDepartament)) {
			if ($this->_id_assigned_departament) {
				$this->ResponsibleDepartament = new departments($this->_id_assigned_departament);
			}
			else {
				$this->ResponsibleDepartament = null;
			}
		}

		return $this->ResponsibleDepartament;
	}
}
