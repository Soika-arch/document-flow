<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці incoming_documents_registry.
 */
class incoming_documents_registry extends DfDocument {

	// Відправник зовнішній.
	protected document_senders $Sender;
	// Отримувач користувач.
	protected users $Recipient;
	protected outgoing_documents_registry $OutgoingDocument;
	// Відповідальний за виконання.
	protected users $ResponsibleUser;
	// Відділ який відповідає за виконання.
	protected departments $ResponsibleDepartament;
	// Чергова дата контролю, яка вираховується на основі поля idr_add_date.
	protected \DateTime|null $NextControlDate;
	protected document_control_types $ControlType;
	// Кількість днів до встановленої дати виконання.
	protected int|null $numberDaysUntilExecutionDate;

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
	 * @return outgoing_documents_registry
	 */
	protected function get_OutgoingDocument () {
		if (! isset($this->OutgoingDocument)) {
			$idOutgoingNumber = $this->_id_outgoing_number ? $this->_id_outgoing_number : null;

			$this->OutgoingDocument = new outgoing_documents_registry($idOutgoingNumber);
		}

		return $this->OutgoingDocument;
	}

	/**
	 * @return document_senders
	 */
	protected function get_Sender () {
		if (! isset($this->Sender)) {
			$idSender = $this->_id_sender ? $this->_id_sender : null;

			$this->Sender = new document_senders($idSender);
		}

		return $this->Sender;
	}

	/**
	 * @return users
	 */
	protected function get_Recipient () {
		if (! isset($this->Recipient)) {
			$idRecipient = $this->_id_recipient ? $this->_id_recipient : null;

			$this->Recipient = new users($idRecipient);
		}

		return $this->Recipient;
	}

	/**
	 * @return users
	 */
	protected function get_ResponsibleUser () {
		if (! isset($this->ResponsibleUser)) {
			$idResponsibleUser = $this->_id_responsible_user ? $this->_id_responsible_user : null;

			$this->ResponsibleUser = new users($idResponsibleUser);
		}

		return $this->ResponsibleUser;
	}

	/**
	 * @return departments
	 */
	protected function get_ResponsibleDepartament () {
		if (! isset($this->ResponsibleDepartament)) {
			$idAssignedDepartament = $this->_id_assigned_departament ?
				$this->_id_assigned_departament : null;

			$this->ResponsibleDepartament = new departments($idAssignedDepartament);
		}

		return $this->ResponsibleDepartament;
	}

	/**
	 * @return document_control_types
	 */
	protected function get_ControlType () {
		if (! isset($this->ControlType)) {
			$idExecutionControl = $this->_id_execution_control ? $this->_id_execution_control : null;

			$this->ControlType = new document_control_types($idExecutionControl);
		}

		return $this->ControlType;
	}

	/**
	 * // Ініціалізує та повертає об'єкт \DateTime наступної дати контролю.
	 * @return \DateTime|null
	 */
	protected function get_NextControlDate () {
		if (! isset($this->NextControlDate)) {
			if ($this->_id_execution_control && ! $this->_execution_date &&
					$this->_date_of_receipt_by_executor) {
				$this->get_ControlType();

				$period = $this->ControlType->_seconds;

				// DateTime отримання документа виконавцем.
				$StartDate = new \DateTime($this->_date_of_receipt_by_executor);

				// Різниця в секундах між поточною датою та початковою датою.
				$diffSeconds = (new \DateTime())->getTimestamp() - $StartDate->getTimestamp();

				// Кількість повних періодів, що пройшли з початкової дати.
				$periodsPassed = floor($diffSeconds / $period);

				// Вирахування часу наступної контрольної дати.
				// Якщо чергова контрольна дата сьогодні - встановлюється сьогоднішня дата,
				// інакше - додається ще один відповідний період і встановлюється наступна дата.
				if (((86400 - ($diffSeconds % $period)) > 0)) {
					$nextExecutionTime = $StartDate->getTimestamp() + $periodsPassed * $period;
				}
				else {
					$nextExecutionTime = $StartDate->getTimestamp() + ($periodsPassed + 1) * $period;
				}

				// Преобразуем время следующего выполнения обратно в объект DateTime.
				$this->NextControlDate = (new \DateTime())->setTimestamp($nextExecutionTime);
			}
			else {
				$this->NextControlDate = null;
			}
		}

		return $this->NextControlDate;
	}
}
