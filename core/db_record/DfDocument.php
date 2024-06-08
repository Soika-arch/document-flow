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
	// Тип контроллю за виконанням.
	protected document_control_types $ControlType;
	protected document_resolutions $Resolution;
	protected string|null $cardURL;
	// Ім'я файла документа.
	protected string $fileName;
	protected string $filePath;

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

				$this->cardURL = url('/'. URIModule .'/documents-'. $str .'/card?n='.
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
}
