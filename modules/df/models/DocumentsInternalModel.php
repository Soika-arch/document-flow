<?php

namespace modules\df\models;

use \core\db_record\internal_documents_registry;
use \core\Get;
use \core\RecordSliceRetriever;
use \libs\Paginator;
use \libs\query_builder\SelectQuery;
use \modules\df\models\MainModel;

/**
 * Модель внутрішніх документів.
 */
class DocumentsInternalModel extends MainModel {

	/**
	 * @return array
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 *
	 */
	public function mainPage () {
		$d['title'] = 'Внутрішні документи - Головна';

		return $d;
	}

	/**
	 * @return array
	 */
	public function listPage (int $pageNum=1) {
		$d['title'] = 'Внутрішні документи - Список';

		$SQLDocs = db_getSelect()
			->from(DbPrefix .'internal_documents_registry')
			->columns([DbPrefix .'internal_documents_registry.*'])
			->orderBy('inr_id');

		if (isset($_SESSION['getParameters'])) {
			if (! ($SQLDocs = $this->documentsSearchSQLHendler($SQLDocs))) return false;
		}

		$SQLDocs = new RecordSliceRetriever($SQLDocs);
		// dd($SQLDocs->SQL->prepare(), __FILE__, __LINE__,1);

		$itemsPerPage = 5;

		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);

		$url = url('/df/documents-internal/list?pg=(:num)');

		$Pagin = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);

		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function cardPage (Get $Get) {
		$Us = rg_Rg()->get('Us');

		$dbRow = $this->selectRowByCol(
			DbPrefix .'internal_documents_registry', 'inr_number', $Get->get['n']
		);

		$Doc = new internal_documents_registry($dbRow['inr_id'], $dbRow);

		if ($Obj = $this->checkCardOpenedByExecutor($Doc)) $Doc = $Obj;

		/** @var bool якщо true, то користувач має права реєстратора на редагування. */
		$d['isRegistrarRights'] = (
			($Us->_id === $Doc->_id_user) ||
			($Us->_id === (($Doc->ExecutorUser) && $Doc->ExecutorUser->_id))
		);

		/** @var bool якщо true, то користувач має права адміна на редагування. */
		$d['isAdminRights'] = ($Us->Status->_access_level < 3);

		$d['documentTypes'] = $this->selectRowsByCol(DbPrefix .'document_types');
		$d['dTitles'] = $this->selectRowsByCol(DbPrefix .'document_titles');
		$d['descriptions'] = $this->selectRowsByCol(DbPrefix .'document_descriptions');
		$d['carrierTypes'] = $this->selectRowsByCol(DbPrefix .'document_carrier_types');
		$d['users'] = $this->getDocumentFlowParticipants();
		$d['departments'] = $this->selectRowsByCol(DbPrefix .'departments');
		$d['controlTypes'] = $this->selectRowsByCol(DbPrefix .'document_control_types');

		$d['Doc'] = $Doc;
		$d['title'] = 'Картка внутрішнього документа [ <b>'. $Doc->displayedNumber .'</b> ]';

		return $d;
	}

	/**
	 * @return SelectQuery|false $SQL
	 */
	protected function documentsSearchSQLHendler (SelectQuery $SQL) {
		if (isset(rg_Rg()->get('Get')->get['clear'])) {
			sess_delGetParameters();

			return false;
		}

		$params = $_SESSION['getParameters'];
		$orJoin = [];

		if (isset($params['d_number'])) {
			$SQL->where('inr_number', 'like', '%'. $params['d_number'] .'%');
		}

		if (isset($params['d_age'])) {
			$SQL->whereRaw($SQL->raw('year(inr_document_date)') .' = "'.
				$params['d_age'] .'"');
		}

		if (isset($params['d_month'])) {
			$SQL->whereRaw($SQL->raw('month(inr_document_date)') .' = "'.
				$params['d_month'] .'"');
		}

		if (isset($params['d_day'])) {
			$SQL->whereRaw($SQL->raw('day(inr_document_date)') .' = "'.
				$params['d_day'] .'"');
		}

		if (isset($params['d_location'])) {
			$SQL
				->join(DbPrefix .'departments', 'dp_id', '=', 'inr_id_document_location')
				->where('inr_id_document_location', '=', $params['d_location']);
		}

		if (isset($params['d_sender_user'])) {
			$orJoin['users'][] = 'us_id = inr_id_sender';
			$SQL->where('inr_id_sender', '=', $params['d_sender_user']);
		}

		if (isset($params['d_recipient_user'])) {
			$orJoin['users'][] = 'us_id = inr_id_recipient';
			$SQL->where('inr_id_recipient', '=', $params['d_recipient_user']);
		}

		if (isset($params['d_registrar_user'])) {
			$orJoin['users'][] = 'us_id = inr_id_user';
			$SQL->where('inr_id_user', '=', $params['d_registrar_user']);
		}

		if ($orJoin) {
			foreach ($orJoin as $table => $joinData) {
				$strJoin = '';

				foreach ($joinData as $condition) {
					$strJoin .= ' or '. $condition;
				}

				if (strpos($strJoin, ' or ') === 0) $strJoin = substr($strJoin, 4);

				$SQL->joinRaw(DbPrefix . $table, $strJoin);
			}
		}

		return $SQL;
	}

	/**
	 * @return internal_documents_registry|false
	 */
	public function cardActionPage () {
		$Us = rg_Rg()->get('Us');
		$get = rg_Rg()->get('Get')->get;
		$Post = rg_Rg()->get('Post');
		$post = rg_Rg()->get('Post')->post;
		$dbRow = $this->selectRowByCol(DbPrefix .'internal_documents_registry', 'inr_number', $get['n']);
		$Doc = new internal_documents_registry($dbRow['inr_id'], $dbRow);
		$updated = [];

		/** @var bool Права реєстратора або виконавця на зміну даних. */
		$isRegistrarRights = (
			($Us->Status->_access_level < 4) ||
			($Doc->_id_user === $Us->_id) ||
			(isset($Doc->Executor) && ($Doc->Executor->_id === $Us->_id))
		);

		/** @var bool Права адміна на зміну даних. */
		$isAdminRights = ($Us->Status->_access_level < 3);

		/** @var bool Права суперадміна на зміну даних. */
		$isSuperAdminRights = ($Us->Status->_access_level === 1);

		if ($isRegistrarRights) {
			$dIdDocumentType = intval($post['dIdDocumentType']);

			if ($dIdDocumentType) {
				if ($dIdDocumentType !== $Doc->_id_document_type) {
					$updated['inr_id_document_type'] = $dIdDocumentType;
				}
			}

			$dIdTitle = intval($post['dIdTitle']);

			if ($dIdTitle) {
				if ($dIdTitle !== $Doc->_id_title) $updated['inr_id_title'] = $dIdTitle;
			}

			$dDescription = intval($post['dIdDescription']);

			if ($dDescription) {
				if ($dDescription !== $Doc->_id_description) $updated['inr_id_description'] = $dDescription;
			}

			if ($post['dAdditionalNumber']) {
				if (isset($Post->errors['dAdditionalNumber'])) {
					sess_addErrMessage('Отримано неправильний формат поля "Додатковий номер документа"');

					return false;
				}
				else if ($post['dAdditionalNumber'] !== $Doc->_additional_number) {
					$updated['inr_additional_number'] = $post['dAdditionalNumber'];
				}
			}

			$dIdCarrierType = intval($post['dIdCarrierType']);

			if ($dIdCarrierType) {
				if ($dIdCarrierType !== $Doc->_id_carrier_type) {
					$updated['inr_id_carrier_type'] = $dIdCarrierType;
				}
			}

			$dIdExecutorUser = intval($post['dIdExecutorUser']);

			if ($dIdExecutorUser && ($dIdExecutorUser !== $Doc->_id_assigned_user)) {
				$updated['inr_id_assigned_user'] = $dIdExecutorUser;
				$updated['inr_date_of_receipt_by_executor'] = null;
			}

			$dIdResponsibleUser = intval($post['dIdResponsibleUser']);

			if ($dIdResponsibleUser && ($dIdResponsibleUser !== $Doc->_id_responsible_user)) {
				$updated['inr_id_responsible_user'] = $dIdResponsibleUser;
			}

			if ($post['dDate']) {
				$dt = tm_getDatetime($post['dDate'])->format('Y-m-d');

				if ($dt !== $Doc->_document_date) $updated['inr_document_date'] = $dt;
			}

			$dIdDocumentLocation = intval($post['dIdDocumentLocation']);

			if ($dIdDocumentLocation && ($dIdDocumentLocation !== $Doc->_id_document_location)) {
				$updated['inr_id_document_location'] = $dIdDocumentLocation;
			}

			$dIdInitiator = intval($post['dIdInitiator']);

			if ($dIdInitiator && ($dIdInitiator !== $Doc->_id_initiator)) {
				$updated['inr_id_initiator'] = $dIdInitiator;
			}

			$dIdRecipient = intval($post['dIdRecipient']);

			if ($dIdRecipient && ($dIdRecipient !== $Doc->_id_recipient)) {
				$updated['inr_id_recipient'] = $dIdRecipient;
			}

			if ($post['dDueDateBefore']) {
				$dt = tm_getDatetime($post['dDueDateBefore'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_control_date) $updated['inr_control_date'] = $dt;
			}

			if ($post['dExecutionDate']) {
				$dt = tm_getDatetime($post['dExecutionDate'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_control_date) $updated['inr_execution_date	'] = $dt;
			}

			$dIdControlType = intval($post['dIdControlType']);

			if ($dIdControlType && ($dIdControlType !== $Doc->_id_execution_control)) {
				$updated['inr_id_execution_control'] = $dIdControlType;
			}
		}

		if ($isAdminRights) {
			$dIdRegistrar = intval($post['dIdRegistrar']);

			if ($dIdRegistrar && ($dIdRegistrar !== $Doc->_id_user)) {
				$updated['inr_id_user'] = $dIdRegistrar;
			}

			if ($post['dNumber']) {
				$newDocNumber = substr($post['dNumber'], 4);
				if ($newDocNumber !== $Doc->_number) $updated['inr_number'] = $newDocNumber;
			}

			if ($post['dIsReceivedExecutorUser'] && ! isset($updated['inr_date_of_receipt_by_executor'])) {
				$dt = tm_getDatetime($post['dIsReceivedExecutorUser'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_date_of_receipt_by_executor) {
					$updated['inr_date_of_receipt_by_executor'] = $dt;
				}
			}
		}

		if ($isSuperAdminRights) {
			if ($post['dRegistrationDate']) {
				$Dt = tm_getDatetime($post['dRegistrationDate']);
				$dtStr = $Dt->format('Y-m-d H:i:s');

				if ($dtStr !== $Doc->_add_date) $updated['inr_add_date'] = $dtStr;
			}
		}

		if ($updated) {
			if (! $Doc->update($updated)) return false;
		}

		return $Doc;
	}
}
