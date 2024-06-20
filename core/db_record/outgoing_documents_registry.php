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
	// Чергова дата контролю, яка вираховується на основі поля idr_add_date.
	protected \DateTime|false $NextControlDate;
	// Якщо дата до якої треба виконати в минулому. Якщо дата до якої треба виконати не встановлена -
	// 0, якщо дата у майбутньому - 1, якщо дата до якої треба виконати у минулому - 2.
	protected int $isOverdue;

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

			$this->Recipient = new document_senders($idRecipient);
		}

		return $this->Recipient;
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
}
