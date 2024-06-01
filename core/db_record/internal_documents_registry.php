<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці internal_documents_registry.
 */
class internal_documents_registry extends DfDocument {

	// Ініціатор користувач.
	protected users|null $InitiatorUser;
	// Отримувач користувач.
	protected users|null $Recipient;
	// Відповідальний за виконання.
	protected users|null $ResponsibleUser;
	// Відділ який відповідає за виконання.
	protected departments|null $ResponsibleDepartament;

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

	/**
	 * @return users
	 */
	protected function get_InitiatorUser () {
		if (! isset($this->InitiatorUser) && $this->_id_initiator) {
			$this->InitiatorUser = new users($this->_id_initiator);
		}
		else {
			$this->InitiatorUser = null;
		}

		return $this->InitiatorUser;
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
