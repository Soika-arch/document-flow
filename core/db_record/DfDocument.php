<?php

namespace core\db_record;

/**
 * .
 */
class DfDocument extends DbRecord {

	// Тип документа.
	protected document_types $DocumentType;
	// Номер документа, що відображається.
	protected string|null $displayedNumber;
	protected string $displayedNumberPrefix;
	protected document_titles $DocumentTitle;
	protected document_descriptions $Description;
	protected document_carrier_types $CarrierType;
	protected departments $DocumentLocation;
	// Користувач, який зареєстрував документ.
	protected users $Registrar;
	// Виконавець користувач.
	protected users $ExecutorUser;
	// Відповідальний за виконання користувач.
	protected users $ResponsibleUser;
	// Тип контроллю за виконанням.
	protected document_control_types $ControlType;
	protected document_resolutions $Resolution;
	protected string|null $cardURL;
	// Ім'я файла документа.
	protected string $fileName;
	protected string $filePath;
	// Якщо прострочена дата виконання - true, інакше - false.
	// Дата виконання може бути простроченою, тільки якщо є дата, до якої потрібно виконати документ.
	// Якщо дати виконання не існує, ябо дата виконання пізніша за дату, до якої документ потрібно
	// виконати, то виконання вважається простроченим і $isDueDateOverdue === true.
	protected bool $isDueDateOverdue;
	// Чергова дата контролю, яка вираховується на основі поля idr_add_date.
	protected \DateTime|false $NextControlDate;
	/** @var bool Чи дата отримання виконавцем є сьогоднішньою датою. */
	protected bool|null $isDateReceivedEqualToTodayDate;

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		$this->tName = DbPrefix . substr(get_called_class(), (strrpos(get_called_class(), '\\') + 1));
		parent::__construct($id, $dbRow);
	}

	/**
	 * @return document_types
	 */
	protected function get_DocumentType () {
		if (! isset($this->DocumentType)) {
			$this->DocumentType = new document_types($this->_id_document_type);
		}

		return $this->DocumentType;
	}

	/**
	 * @return string
	 */
	protected function get_displayedNumber () {
		if (! isset($this->displayedNumber) && $this->_number) {
			$this->displayedNumber = $this->displayedNumberPrefix . $this->_number;
		}
		else {
			$this->displayedNumber = null;
		}

		return $this->displayedNumber;
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

	/**
	 * @return document_descriptions
	 */
	protected function get_Description () {
		if (! isset($this->Description)) {
			$idDescription = $this->_id_description ? $this->_id_description : null;

			$this->Description = new document_descriptions($idDescription);
		}

		return $this->Description;
	}

	/**
	 * @return document_carrier_types
	 */
	protected function get_CarrierType () {
		if (! isset($this->CarrierType)) {
			$idCarrierType = $this->_id_carrier_type ? $this->_id_carrier_type : null;

			$this->CarrierType = new document_carrier_types($idCarrierType);
		}

		return $this->CarrierType;
	}

	/**
	 * @return departments|null
	 */
	protected function get_DocumentLocation () {
		if (! isset($this->DocumentLocation)) {
			$idDocumentLocation = $this->_id_document_location ? $this->_id_document_location : null;

			$this->DocumentLocation = new departments($idDocumentLocation);
		}

		return $this->DocumentLocation;
	}

	/**
	 * @return users
	 */
	protected function get_Registrar () {
		if (! isset($this->Registrar)) {
			$this->Registrar = new users($this->_id_user);
		}

		return $this->Registrar;
	}

	/**
	 * @return users
	 */
	protected function get_ExecutorUser () {
		if (! isset($this->ExecutorUser)) {
			$idAssignedUser = $this->_id_assigned_user ? $this->_id_assigned_user : null;

			$this->ExecutorUser = new users($idAssignedUser);
		}

		return $this->ExecutorUser;
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
	 * @return document_resolutions
	 */
	protected function get_Resolution () {
		if (! isset($this->Resolution)) {
			$idResolution = $this->_id_resolution ? $this->_id_resolution : null;

			$this->Resolution = new document_resolutions($idResolution);
		}

		return $this->Resolution;
	}

	/**
	 * @return string|null
	 */
	protected function get_cardURL () {
		if (! isset($this->cardURL)) {
			if ($this->_number) {
				$str = str_replace(DbPrefix, '', $this->tName);
				$str = substr($str, 0, strpos($str, '_'));

				$this->cardURL = url('/df/documents-'. $str .'/card?n='.
					str_replace('inc_', '', $this->_number));
			}
			else {
				$this->cardURL = null;
			}
		}

		return $this->cardURL;
	}

	/**
	 * @return string
	 */
	protected function get_fileName () {
		if (! isset($this->fileName)) {
			$this->fileName = $this->displayedNumberPrefix . $this->_number .'.'. $this->_file_extension;
		}

		return $this->fileName;
	}

	/**
	 * @return string
	 */
	protected function get_filePath () {
		if (! isset($this->filePath)) {
			$this->filePath = DirRoot .'/modules/'. URIModule .'/storage/'. $this->get_fileName();
		}

		return $this->filePath;
	}

	/**
	 * @return bool
	 */
	protected function get_isDueDateOverdue () {
		if (! isset($this->isDueDateOverdue) && $this->_control_date) {
			if ($this->_execution_date) {
				$this->isDueDateOverdue =
					date('Y-m-d', strtotime($this->_execution_date)) >
					date('Y-m-d', strtotime($this->_control_date));
			}
			else {
				$this->isDueDateOverdue = date('Y-m-d') > date('Y-m-d', strtotime($this->_control_date));
			}
		}
		else {
			$this->isDueDateOverdue = false;
		}

		return $this->isDueDateOverdue;
	}

	/**
	 * @return bool|null
	 */
	protected function get_isDateReceivedEqualToTodayDate () {
		if (! isset($this->isDateReceivedEqualToTodayDate)) {
			if ($this->_date_of_receipt_by_executor) {
				$this->isDateReceivedEqualToTodayDate =
					date('Y-m-d', strtotime($this->_date_of_receipt_by_executor)) === date('Y-m-d');
			}
			else {
				$this->isDateReceivedEqualToTodayDate = null;
			}
		}

		return $this->isDateReceivedEqualToTodayDate;
	}

	/**
	 * @return false|$this
	 */
	public function initByDocNumber (string $docNumber) {
		$QB = db_DTSelect($this->tName .'.'. $this->px .'id')
			->from($this->tName)
			->where($this->px .'number = :docNumber')
			->setParameter('docNumber', $docNumber);

		if ($row = $QB->fetchAllNumeric()) {
			$this->initById($row[0][0]);

			return $this;
		}

		return false;
	}

	/**
	 * Отримання логіна користувача, який зареєстрував документ.
	 * @return string
	 */
	public function getRegistrarLogin () {

		return $this->get_Registrar()->_login;
	}

	/**
	 * @return string|null
	 */
	public function getDocumentLocationName () {
		if ($this->get_DocumentLocation()) return $this->DocumentLocation->_name;
	}

	/**
	 * Ініціалізує та повертає об'єкт \DateTime наступної дати контролю.
	 * Дата контролю починає обчислюватись тільки після отримання документа призначеним виконавцем.
	 * @return \DateTime|null
	 */
	protected function get_NextControlDate () {
		if (! isset($this->NextControlDate) && ! $this->get_isDueDateOverdue()) {
			$contrTypeDays = intval($this->get_ControlType()->_seconds / 86400);
			$daysDiff = tm_getDiff(date('Y-m-d', strtotime($this->_control_date)), date('Y-m-d'));

			if ((($daysDiff < 0) || ($daysDiff < $contrTypeDays))) {
				$this->NextControlDate = false;
			}
			else if ($this->_id_execution_control && ! $this->_execution_date &&
					$this->_date_of_receipt_by_executor) {
				$this->get_ControlType();

				$period = $this->ControlType->_seconds;

				// DateTime отримання документа виконавцем.
				$StartDate = new \DateTime($this->_date_of_receipt_by_executor);
				$isDateReceivedEqualToTodayDate = $this->get_isDateReceivedEqualToTodayDate();

				// Різниця в секундах між поточною датою та початковою датою.
				$diffSeconds = (new \DateTime())->getTimestamp() - $StartDate->getTimestamp();

				// Кількість повних періодів, що пройшли з початкової дати.
				$periodsPassed = $period ? floor($diffSeconds / $period) : 0;

				// Вирахування часу наступної контрольної дати.
				// Якщо чергова контрольна дата сьогодні - встановлюється сьогоднішня дата,
				// інакше - додається ще один відповідний період і встановлюється наступна дата.
				// Але якщо сьогоднішня дата є датою отримання документа виконавцем - встановлюється наступна.
				if (!$isDateReceivedEqualToTodayDate && $period && ((86400 - ($diffSeconds % $period)) > 0)) {
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
		else {
			$this->NextControlDate = false;
		}

		return $this->NextControlDate;
	}
}
