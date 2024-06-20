<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці internal_documents_registry.
 */
class internal_documents_registry extends DfDocument {

	// Ініціатор користувач.
	protected users $InitiatorUser;
	// Отримувач користувач.
	protected users $Recipient;
	// Відповідальний за виконання.
	protected users $ResponsibleUser;
	// Відділ який відповідає за виконання.
	protected departments $ResponsibleDepartament;
	// Чергова дата контролю, яка вираховується на основі поля idr_add_date.
	protected \DateTime|false $NextControlDate;
	protected document_control_types $ControlType;
	// Якщо дата до якої треба виконати в минулому. Якщо дата до якої треба виконати не встановлена -
	// 0, якщо дата у майбутньому - 1, якщо дата до якої треба виконати у минулому - 2.
	protected int $isOverdue;
	// Чи настав час нагадування про дату до якої треба виконати.
	protected bool $remindAboutDueDate;

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
		if (! isset($this->InitiatorUser)) {
			$idInitiator = $this->_id_initiator ? $this->_id_initiator : null;

			$this->InitiatorUser = new users($idInitiator);
		}

		return $this->InitiatorUser;
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
	 * Ініціалізує та повертає об'єкт \DateTime наступної дати контролю.
	 * Дата контролю починає обчислюватись тільки після отримання документа призначеним виконавцем.
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
				$periodsPassed = $period ? floor($diffSeconds / $period) : 0;

				// Вирахування часу наступної контрольної дати.
				// Якщо чергова контрольна дата сьогодні - встановлюється сьогоднішня дата,
				// інакше - додається ще один відповідний період і встановлюється наступна дата.
				if ($period && ((86400 - ($diffSeconds % $period)) > 0)) {
					$nextExecutionTime = $StartDate->getTimestamp() + $periodsPassed * $period;
				}
				else {
					$nextExecutionTime = $StartDate->getTimestamp() + ($periodsPassed + 1) * $period;
				}

				// Преобразуем время следующего выполнения обратно в объект DateTime.
				$this->NextControlDate = (new \DateTime())->setTimestamp($nextExecutionTime);
			}
			else {
				$this->NextControlDate = false;
			}
		}

		return $this->NextControlDate;
	}

	/**
	 * @return int (0|1|2)
	 */
	protected function get_isOverdue () {
		if (! isset($this->isOverdue)) {
			if ($this->_control_date) {
				$this->isOverdue = (time() > strtotime($this->_control_date)) ? 2 : 1;
			}
			else {
				$this->isOverdue = 0;
			}
		}

		return $this->isOverdue;
	}

	/**
	 * @return bool
	 */
	protected function get_remindAboutDueDate () {
		if (! isset($this->remindAboutDueDate)) {
			$this->remindAboutDueDate = time() >= (strtotime($this->_control_date) - 172800);
		}

		return $this->remindAboutDueDate;
	}
}
