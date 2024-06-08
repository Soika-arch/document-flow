<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці users.
 */
class users extends DbRecord {

	// Зв'язок користувача з його статусом.
	protected users_rel_statuses $UserRelStatus;
	// Статус користувача.
	protected user_statuses $Status;
	// Масив id невиконаних вхідніх документів користувача.
	protected array $notExecutionIncomingDocuments;
	// Масив id невиконаних внутрішніх документів користувача.
	protected array $notExecutionInternalDocuments;
	// Масив id виконаних вхідніх документів користувача.
	protected array $executionIncomingDocuments;
	// Масив id виконаних внутрішніх документів користувача.
	protected array $executionInternalDocuments;
	protected visitor_routes $VR;

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
			$usrId = isset($row['usr_id']) ? $row['usr_id'] : null;

			$this->UserRelStatus = new users_rel_statuses($usrId, $row);
		}

		return $this->UserRelStatus;
	}

	/**
	 * @return user_statuses
	 */
	protected function get_Status () {
		if (! isset($this->Status)) {
			$this->Status = $this->get_UserRelStatus()->get_UserStatus();
		}

		return $this->Status;
	}

	/**
	 * @return array
	 */
	protected function get_notExecutionIncomingDocuments () {
		if (! isset($this->notExecutionIncomingDocuments)) {
			$SQL = db_getSelect()
				->columns(['idr_id'])
				->from(DbPrefix .'incoming_documents_registry')
				->where('idr_id_assigned_user', '=', $this->_id)
				->where('idr_execution_date', '=', null);

			$this->notExecutionIncomingDocuments = db_selectCol($SQL);
		}

		return $this->notExecutionIncomingDocuments;
	}

	/**
	 * @return array
	 */
	protected function get_executionIncomingDocuments () {
		if (! isset($this->executionIncomingDocuments)) {
			$SQL = db_getSelect()
				->columns(['idr_id'])
				->from(DbPrefix .'incoming_documents_registry')
				->where('idr_id_assigned_user', '=', $this->_id)
				->where('idr_execution_date', '!=', null);

			$this->executionIncomingDocuments = db_selectCol($SQL);
		}

		return $this->executionIncomingDocuments;
	}

	/**
	 * @return array
	 */
	protected function get_notExecutionInternalDocuments () {
		if (! isset($this->notExecutionInternalDocuments)) {
			$SQL = db_getSelect()
				->columns(['inr_id'])
				->from(DbPrefix .'internal_documents_registry')
				->where('inr_id_assigned_user', '=', $this->_id)
				->where('inr_execution_date', '=', null);

			$this->notExecutionInternalDocuments = db_selectCol($SQL);
		}

		return $this->notExecutionInternalDocuments;
	}

	/**
	 * @return array
	 */
	protected function get_executionInternalDocuments () {
		if (! isset($this->executionInternalDocuments)) {
			$SQL = db_getSelect()
				->columns(['inr_id'])
				->from(DbPrefix .'internal_documents_registry')
				->where('inr_id_assigned_user', '=', $this->_id)
				->where('inr_execution_date', '!=', null);

			$this->executionInternalDocuments = db_selectCol($SQL);
		}

		return $this->executionInternalDocuments;
	}

	/**
	 * @return visitor_routes
	 */
	protected function get_VR () {
		if (isset($this->VR)) return $this->VR;
	}

	/**
	 *
	 */
	protected function set_Status (user_statuses $Status) {
		$this->Status = $Status;
	}
}
