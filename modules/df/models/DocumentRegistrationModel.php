<?php

namespace modules\df\models;

use \core\db_record\incoming_documents_registry;
use \core\db_record\internal_documents_registry;
use \core\db_record\outgoing_documents_registry;
use \core\User;
use \core\Post;
use \modules\df\models\MainModel;

/**
 * Модель типів документів.
 */
class DocumentRegistrationModel extends MainModel {

	/**
	 *
	 */
	public function __construct () {
		parent::__construct();
	}

	public function incomingPage () {
		$d['title'] = 'Реєстрація вхідного документа';
		$d['users'] = $this->selectRowsByCol(DbPrefix .'users', 'us_id', '0', [], '>');
		$d['documentTypes'] = $this->selectRowsByCol(DbPrefix .'document_types');
		$d['titles'] = $this->selectRowsByCol(DbPrefix .'document_titles');
		$d['descriptions'] = $this->selectRowsByCol(DbPrefix .'document_descriptions');
		$d['carrierTypes'] = $this->selectRowsByCol(DbPrefix .'document_carrier_types');
		$d['documentStatuses'] = $this->selectRowsByCol(DbPrefix .'document_statuses');
		$d['departaments'] = $this->selectRowsByCol(DbPrefix .'departments');
		$d['resolutions'] = $this->selectRowsByCol(DbPrefix .'document_resolutions');
		$d['controlTypes'] = $this->selectRowsByCol(DbPrefix .'document_control_types');
		$d['senders'] = $this->selectRowsByCol(DbPrefix .'document_senders');
		$d['terms'] = $this->selectRowsByCol(DbPrefix .'terms_of_execution');

		return $d;
	}

	public function outgoingPage () {
		$d['title'] = 'Реєстрація в<b>и</b>хідного документа';
		$d['users'] = $this->selectRowsByCol(DbPrefix .'users', 'us_id', '0', [], '>');
		$d['documentTypes'] = $this->selectRowsByCol(DbPrefix .'document_types');
		$d['registrationForms'] = $this->selectRowsByCol(DbPrefix .'registration_forms');
		$d['titles'] = $this->selectRowsByCol(DbPrefix .'document_titles');
		$d['descriptions'] = $this->selectRowsByCol(DbPrefix .'document_descriptions');
		$d['carrierTypes'] = $this->selectRowsByCol(DbPrefix .'document_carrier_types');
		$d['documentStatuses'] = $this->selectRowsByCol(DbPrefix .'document_statuses');
		$d['departaments'] = $this->selectRowsByCol(DbPrefix .'departments');
		$d['controlTypes'] = $this->selectRowsByCol(DbPrefix .'document_control_types');
		$d['recipients'] = $this->selectRowsByCol(DbPrefix .'document_senders');
		$d['terms'] = $this->selectRowsByCol(DbPrefix .'terms_of_execution');

		return $d;
	}

	public function internalPage () {
		$d['title'] = 'Реєстрація внутрішнього документа';
		$d['users'] = $this->selectRowsByCol(DbPrefix .'users', 'us_id', '0', [], '>');
		$d['documentTypes'] = $this->selectRowsByCol(DbPrefix .'document_types');
		$d['titles'] = $this->selectRowsByCol(DbPrefix .'document_titles');
		$d['descriptions'] = $this->selectRowsByCol(DbPrefix .'document_descriptions');
		$d['carrierTypes'] = $this->selectRowsByCol(DbPrefix .'document_carrier_types');
		$d['documentStatuses'] = $this->selectRowsByCol(DbPrefix .'document_statuses');
		$d['departaments'] = $this->selectRowsByCol(DbPrefix .'departments');
		$d['controlTypes'] = $this->selectRowsByCol(DbPrefix .'document_control_types');
		$d['recipients'] = $this->selectRowsByCol(DbPrefix .'document_senders');
		$d['terms'] = $this->selectRowsByCol(DbPrefix .'terms_of_execution');

		return $d;
	}

	/**
	 * Генерація вільного номеру вхідного документа.
	 * @return string
	 */
	public function generateDocumentNumber (string $tName, string $px, int $length) {
		$SQL = db_getSelect();

		$SQL
			->columns([$SQL->raw('max('. $px .'id) MAX_ID')])
			->from(DbPrefix . $tName);

		$maxId = db_selectCell($SQL);

		return formatWithLeadingZeros(($maxId + 1), $length);
	}

	/**
	 * Генерація вільного номеру вхідного документа.
	 * @return string
	 */
	public function generateIncomingNumber (int $length=8) {

		return $this->generateDocumentNumber('incoming_documents_registry', 'idr_', $length);
	}

	/**
	 * @return string
	 */
	public function generateOutgoingNumber (int $length=8) {

		return $this->generateDocumentNumber('outgoing_documents_registry', 'odr_', $length);
	}

	/**
	 * @return string
	 */
	public function generateInternalNumber (int $length=8) {

		return $this->generateDocumentNumber('internal_documents_registry', 'inr_', $length);
	}

	/**
	 * Додавання до бази нового вхідного документа.
	 * @return incoming_documents_registry
	 */
	public function addIncomingDocument (Post $Post) {
		/** @var User */
		$Us = rg_Rg()->get('Us');
		// Отримання номеру можливого відповідного вихідного документа.
		$numOutDoc = getArrayValue($Post->post, 'dOutgoingNumber', null);

		// Перевірка існування відповідного вихідного документа.
		if ($numOutDoc) {
			/** @var int id відповідного вихідного документа. */
			$idOutDoc = $this->selectCellByCol(
				DbPrefix .'outgoing_documents_registry', 'odr_number', $numOutDoc, 'odr_id'
			);

			if (! $idOutDoc) {
				// Відповідний вихідний документ не знайдено.
				sess_addErrMessage('Не знайдено вказаний номер відповідного вихідного документа');
				hd_sendHeader('Location: '. url('/df/document-registration/incoming'), __FILE__, __LINE__);
			}
		}
		else {
			/** @var int id відповідного вихідного документа. */
			$idOutDoc = null;
		}

		$newDocNum = $this->generateIncomingNumber();

		// Обробка завантаженого файлу документа.
		$pathInfo = pathinfo($_FILES['dFile']['name']);
		$storagePath = $this->get_storagePath();
		$newDocName = 'INC_'. $newDocNum .'.'. $pathInfo['extension'];

		// Спроба переміщення завантаженого файла документа з тимчасового каталога до $storagePath.
		if (! move_uploaded_file($_FILES['dFile']['tmp_name'], $storagePath .'/'. $newDocName)) {
			sess_addErrMessage('Помилка завантаження файла');
			hd_sendHeader('Location: '. url('/df/document-registration/incoming'), __FILE__, __LINE__);
		}

		$dtNow = tm_convertToDatetime();

		if (isset($Post->post['dControlType']) && $Post->post['dControlType']) {
			$termOfExecution = $Post->post['dControlTerm'];
		}
		else {
			$termOfExecution = null;
		}

		return (new incoming_documents_registry(null))->set([
			'idr_id_user' => $Us->_id,
			'idr_id_document_type' => $Post->post['dType'],
			'idr_id_carrier_type' => $Post->post['dCarrierType'],
			'idr_id_document_location' => getArrayValue($Post->post, 'dLocation', null),
			'idr_number' => $newDocNum,
			'idr_id_outgoing_number' => $idOutDoc,
			'idr_id_title' => $Post->post['dTitle'],
			'idr_document_date' => getArrayValue($Post->post, 'dIncomingDate', null),
			'idr_id_recipient' => getArrayValue($Post->post, 'dRecipientUser', null),
			'idr_id_sender' => $Post->post['dSender'],
			'idr_id_description' => getArrayValue($Post->post, 'dDescription', null),
			'idr_file_extension' => $pathInfo['extension'],
			'idr_id_status' => getArrayValue($Post->post, 'dStatus', null),
			'idr_id_responsible_user' => getArrayValue($Post->post, 'dResponsibleUser', null),
			'idr_id_assigned_user' => getArrayValue($Post->post, 'dAssignedUser', null),
			'idr_id_assigned_departament' => getArrayValue($Post->post, 'dAssignedDepartament', null),
			'idr_id_resolution' => getArrayValue($Post->post, 'dResolution', null),
			'idr_resolution_date' => null,
			'idr_date_of_receipt_by_executor' => null,
			'idr_id_execution_control' => getArrayValue($Post->post, 'dControlType', null),
			'idr_id_term_of_execution' => $termOfExecution,
			'idr_control_date' => getArrayValue($Post->post, 'dExecutionDeadline', null),
			'idr_execution_date' => null,
			'idr_add_date' => $dtNow,
			'idr_change_date' => $dtNow
		]);
	}

	/**
	 * Додавання до бази нового вихідного документа.
	 * @return outgoing_documents_registry
	 */
	public function addOutgoingDocument (Post $Post) {
		/** @var User */
		$Us = rg_Rg()->get('Us');
		$numIncDoc = getArrayValue($Post->post, 'dIncomingNumber', null);

		if ($numIncDoc) {
			/** @var int id відповідного вхідного документа. */
			$idIncDoc = $this->selectCellByCol(
				DbPrefix .'incoming_documents_registry', 'idr_number', $numIncDoc, 'idr_id'
			);

			if (! $idIncDoc) {
				sess_addErrMessage('Не знайдено вказаний номер відповідного вхідного документа');
				hd_sendHeader('Location: '. url('/df/document-registration/outgoing'), __FILE__, __LINE__);
			}
		}
		else {
			/** @var int id відповідного вхідного документа. */
			$idIncDoc = null;
		}

		$newDocNum = $this->generateIncomingNumber();

		// Обробка завантаженого файлу документа.
		$pathInfo = pathinfo($_FILES['dFile']['name']);
		$storagePath = $this->get_storagePath();
		$newDocName = 'OUT_'. $newDocNum .'.'. $pathInfo['extension'];

		// Спроба переміщення завантаженого файла документа з тимчасового каталога до $storagePath.
		if (! move_uploaded_file($_FILES['dFile']['tmp_name'], $storagePath .'/'. $newDocName)) {
			sess_addErrMessage('Помилка завантаження файла');
			hd_sendHeader('Location: '. url('/df/document-registration/incoming'), __FILE__, __LINE__);
		}

		$dtNow = tm_convertToDatetime();

		return (new outgoing_documents_registry(null))->set([
			'odr_id_user' => $Us->_id,
			'odr_id_document_type' => $Post->post['dType'],
			'odr_id_carrier_type' => $Post->post['dCarrierType'],
			'odr_id_document_location' => getArrayValue($Post->post, 'dLocation', null),
			'odr_number' => $newDocNum,
			'odr_id_incoming_number' => $idIncDoc,
			'odr_registration_form_number' => getArrayValue($Post->post, 'registrationForm', null),
			'odr_id_title' => $Post->post['dTitle'],
			'odr_document_date' => getArrayValue($Post->post, 'dOutgoingDate', null),
			'odr_id_sender' => $Post->post['dSender'],
			'odr_id_recipient' => getArrayValue($Post->post, 'dRecipientUser', null),
			'odr_id_description' => getArrayValue($Post->post, 'dDescription', null),
			'odr_file_extension' => $pathInfo['extension'],
			'odr_id_status' => getArrayValue($Post->post, 'dStatus', null),
			'odr_id_assigned_user' => getArrayValue($Post->post, 'dAssignedUser', null),
			'odr_id_execution_control' => getArrayValue($Post->post, 'dControlType', null),
			'odr_control_date' => getArrayValue($Post->post, 'dExecutionDeadline', null),
			'odr_execution_date' => null,
			'odr_add_date' => $dtNow,
			'odr_change_date' => $dtNow
		]);
	}

	/**
	 * Додавання до бази нового внутрішнього документа.
	 * @return internal_documents_registry
	 */
	public function addInternalDocument (Post $Post) {
		/** @var User */
		$Us = rg_Rg()->get('Us');

		$newDocNum = $this->generateInternalNumber();

		// Обробка завантаженого файлу документа.
		$pathInfo = pathinfo($_FILES['dFile']['name']);
		$storagePath = $this->get_storagePath();
		$newDocName = 'INT_'. $newDocNum .'.'. $pathInfo['extension'];

		// Спроба переміщення завантаженого файла документа з тимчасового каталога до $storagePath.
		if (! move_uploaded_file($_FILES['dFile']['tmp_name'], $storagePath .'/'. $newDocName)) {
			sess_addErrMessage('Помилка завантаження файла');
			hd_sendHeader('Location: '. url('/df/document-registration/internal'), __FILE__, __LINE__);
		}

		$dtNow = tm_convertToDatetime();

		if (isset($Post->post['dControlType']) && $Post->post['dControlType']) {
			$termOfExecution = $Post->post['dControlTerm'];
		}
		else {
			$termOfExecution = null;
		}

		return (new internal_documents_registry(null))->set([
			'inr_id_user' => $Us->_id,
			'inr_id_carrier_type' => $Post->post['dCarrierType'],
			'inr_id_document_location' => getArrayValue($Post->post, 'dLocation', null),
			'inr_number' => $newDocNum,
			'inr_additional_number' => getArrayValue($Post->post, 'dAdditionalNumber', null),
			'inr_id_title' => $Post->post['dTitle'],
			'inr_id_description' => getArrayValue($Post->post, 'dDescription', null),
			'inr_document_date' => getArrayValue($Post->post, 'dInternalDate', null),
			'inr_id_initiator' => $Post->post['dUserInitiator'],
			'inr_id_recipient' => getArrayValue($Post->post, 'dRecipientUser', null),
			'inr_id_status' => getArrayValue($Post->post, 'dStatus', null),
			'inr_id_responsible_user' => getArrayValue($Post->post, 'dResponsibleUser', null),
			'inr_id_assigned_departament' => getArrayValue($Post->post, 'dAssignedDepartament', null),
			'inr_id_assigned_user' => getArrayValue($Post->post, 'dAssignedUser', null),
			'inr_date_of_receipt_by_executor' => null,
			'inr_id_execution_control' => getArrayValue($Post->post, 'dControlType', null),
			'inr_id_term_of_execution' => $termOfExecution,
			'inr_control_date' => getArrayValue($Post->post, 'dExecutionDeadline', null),
			'inr_execution_date' => null,
			'inr_distribution_scope' => getArrayValue($Post->post, 'distributionScope', null),
			'inr_file_extension' => $pathInfo['extension'],
			'inr_id_document_type' => $Post->post['dType'],
			'inr_add_date' => $dtNow,
			'inr_change_date' => $dtNow
		]);
	}
}
