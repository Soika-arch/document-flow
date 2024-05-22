<?php

namespace modules\df\models;

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
		$d['controlTypes'] = $this->selectRowsByCol(DbPrefix .'document_control_types');
		$d['recipients'] = $this->selectRowsByCol(DbPrefix .'document_senders');
		$d['terms'] = $this->selectRowsByCol(DbPrefix .'terms_of_execution');

		return $d;
	}

	/**
	 * @return string
	 */
	public function generateIncomingNumber () {
		$pref = 'inc_';
		$rStr = $pref . randStr(6);

		$SQL = $this->selectCellByCol(
			DbPrefix .'incoming_documents_registry', 'idr_number', $rStr, 'idr_id', '=', false
		);

		while (db_selectCell($SQL)) {
			$rStr = $pref . randStr(6);

			$SQL = $this->selectCellByCol(
				DbPrefix .'incoming_documents_registry', 'idr_number', $rStr, 'idr_id', '=', false
			);
		}

		return $rStr;
	}

	/**
	 * @return string
	 */
	public function generateOutgoingNumber () {
		$pref = 'out_';
		$rStr = $pref . randStr(6);

		$SQL = $this->selectCellByCol(
			DbPrefix .'outgoing_documents_registry', 'odr_number', $rStr, 'odr_id', '=', false
		);

		while (db_selectCell($SQL)) {
			$rStr = $pref . randStr(6);

			$SQL = $this->selectCellByCol(
				DbPrefix .'outgoing_documents_registry', 'odr_number', $rStr, 'odr_id', '=', false
			);
		}

		return $rStr;
	}

	/**
	 * @return
	 */
	public function addIncomingDocument (Post $Post) {
		/** @var User */
		$Us = rg_Rg()->get('Us');
		$numOutDoc = getArrayValue($Post->post, 'dOutgoingNumber', null);

		if ($numOutDoc) {
			$idOutDoc = $this->selectCellByCol(
				DbPrefix .'outgoing_documents_registry', 'odr_number', $numOutDoc, 'odr_id'
			);

			if (! $idOutDoc) {
				sess_addErrMessage('Не знайдено вказаний номер відповідного вихідного документа');
				hd_sendHeader('Location: '. url('/df/document-registration/incoming'), __FILE__, __LINE__);
			}
		}
		else {
			$idOutDoc = null;
		}

		$newDocNum = $this->generateIncomingNumber();
		$pathInfo = pathinfo($_FILES['dFile']['name']);
		$storage = DirModules .'/'. URIModule .'/storage';
		$newDocName = $newDocNum .'.'. $pathInfo['extension'];

		if (! move_uploaded_file($_FILES['dFile']['tmp_name'], $storage .'/'. $newDocName)) {
			sess_addErrMessage('Помилка завантаження файла');
			hd_sendHeader('Location: '. url('/df/document-registration/incoming'), __FILE__, __LINE__);
		}

		$SQL = db_getInsert();

		$dtNow = tm_convertToDatetime();

		if (isset($Post->post['dControlType']) && $Post->post['dControlType']) {
			$termOfExecution = $Post->post['dControlTerm'];
		}
		else {
			$termOfExecution = null;
		}

		$SQL
			->into(DbPrefix .'incoming_documents_registry')
			->set(
				[
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
				]
		);

		return db_insertRow($SQL);
	}

	/**
	 * @return
	 */
	public function addOutgoingDocument (Post $Post) {
		/** @var User */
		$Us = rg_Rg()->get('Us');
		$numIncDoc = getArrayValue($Post->post, 'dIncomingNumber', null);

		if ($numIncDoc) {
			$idIncDoc = $this->selectCellByCol(
				DbPrefix .'incoming_documents_registry', 'idr_number', $numIncDoc, 'idr_id'
			);

			if (! $idIncDoc) {
				sess_addErrMessage('Не знайдено вказаний номер відповідного вхідного документа');
				hd_sendHeader('Location: '. url('/df/document-registration/outgoing'), __FILE__, __LINE__);
			}
		}
		else {
			$idIncDoc = null;
		}

		$newDocNum = $this->generateOutgoingNumber();
		$pathInfo = pathinfo($_FILES['dFile']['name']);
		$storage = DirModules .'/'. URIModule .'/storage';
		$newDocName = $newDocNum .'.'. $pathInfo['extension'];

		if (! move_uploaded_file($_FILES['dFile']['tmp_name'], $storage .'/'. $newDocName)) {
			sess_addErrMessage('Помилка завантаження файла');
			hd_sendHeader('Location: '. url('/df/document-registration/outgoing'), __FILE__, __LINE__);
		}

		$SQL = db_getInsert();

		$dtNow = tm_convertToDatetime();

		$SQL
			->into(DbPrefix .'outgoing_documents_registry')
			->set(
				[
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
				]
		);

		return db_insertRow($SQL);
	}
}
