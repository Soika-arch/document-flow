<?php

namespace core\db_record;

/**
 * .
 */
class DfDocument extends DbRecord {

	// Номер документа, що відображається.
	protected string|null $displayedNumber;
	protected string $displayedNumberPrefix;
	protected document_titles $DocumentTitle;
	protected document_descriptions|null $Description;
	protected departments|null $DocumentLocation;
	// Користувач, який зареєстрував документ.
	protected users $Registrar;
	// Виконавець користувач.
	protected users|null $ExecutorUser;
	// Тип контроллю за виконанням.
	protected document_control_types|null $ControlType;
	protected document_resolutions|null $Resolution;
	protected string $cardURL;
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
		if (! isset($this->Description) && $this->_id_description) {
			$this->Description = new document_descriptions($this->_id_description);
		}
		else {
			$this->Description = null;
		}

		return $this->Description;
	}

	/**
	 * @return departments|null
	 */
	protected function get_DocumentLocation () {
		if (! isset($this->DocumentLocation) && $this->_id_document_location) {
			$this->DocumentLocation = new departments($this->_id_document_location);
		}
		else {
			$this->DocumentLocation = null;
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
			if ($this->_id_assigned_user) {
				$this->ExecutorUser = new users($this->_id_assigned_user);
			}
			else {
				$this->ExecutorUser = null;
			}
		}

		return $this->ExecutorUser;
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
	 * @return document_control_types
	 */
	protected function get_ControlType () {
		if (! isset($this->ControlType) && $this->_id_execution_control) {
			$this->ControlType = new document_control_types($this->_id_execution_control);
		}
		else {
			$this->ControlType = null;
		}

		return $this->ControlType;
	}

	/**
	 * @return document_resolutions|null
	 */
	protected function get_Resolution () {
		if (! isset($this->Resolution) && $this->_id_resolution) {
			$this->Resolution = new document_resolutions($this->_id_resolution);
		}
		else {
			$this->Resolution = null;
		}

		return $this->Resolution;
	}

	/**
	 * @return string
	 */
	protected function get_cardURL () {
		if (! isset($this->cardURL) && $this->_number) {
			$str = str_replace(DbPrefix, '', $this->tName);
			$str = substr($str, 0, strpos($str, '_'));

			$this->cardURL = url('/'. URIModule .'/documents-'. $str .'/card?n='.
				str_replace('inc_', '', $this->_number));
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
