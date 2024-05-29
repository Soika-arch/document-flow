<?php

namespace modules\df\models;

use \core\db_record\outgoing_documents_registry;
use \core\RecordSliceRetriever;
use \libs\Paginator;
use \libs\query_builder\SelectQuery;
use \modules\df\models\MainModel;

/**
 * Модель вихідних документів.
 */
class DocumentsOutgoingModel extends MainModel {

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
		$d['title'] = 'Вихідні документи - Головна';

		return $d;
	}

	/**
	 * @return array
	 */
	public function listPage (int $pageNum=1) {
		$d['title'] = 'Вихідні документи - Список';

		$SQLDocs = db_getSelect()
			->from(DbPrefix .'outgoing_documents_registry')
			->columns([DbPrefix .'outgoing_documents_registry.*'])
			->orderBy('odr_id');

		if (isset($_SESSION['getParameters'])) {
			if (! ($SQLDocs = $this->documentsSearchSQLHendler($SQLDocs))) return false;
		}

		$SQLDocs = new RecordSliceRetriever($SQLDocs);
		// dd($SQLDocs->SQL->prepare(), __FILE__, __LINE__,1);

		$itemsPerPage = 5;

		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);

		$url = url('/df/documents-outgoing/list?pg=(:num)');

		$Pagin = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);

		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function cardPage () {
		$Us = rg_Rg()->get('Us');
		$get = rg_Rg()->get('Get')->get;

		$dbRow = $this->selectRowByCol(
			DbPrefix .'outgoing_documents_registry', 'odr_number', $get['n']
		);

		$Doc = new outgoing_documents_registry($dbRow['odr_id'], $dbRow);

		/** @var bool якщо true, то користувач має права реєстратора на редагування. */
		$d['isRegistrarRights'] = (
			($Us->_id === $Doc->_id_user) ||
			($Us->_id === (($Doc->ExecutorUser) && $Doc->ExecutorUser->_id))
		);

		/** @var bool якщо true, то користувач має права адміна на редагування. */
		$d['isAdminRights'] = ($Us->Status->_access_level < 3);

		$d['dTitles'] = $this->selectRowsByCol(DbPrefix .'document_titles');
		$d['descriptions'] = $this->selectRowsByCol(DbPrefix .'document_descriptions');
		$d['users'] = $this->getDocumentFlowParticipants();
		$d['senders'] = $this->selectRowsByCol(DbPrefix .'document_senders');
		$d['departments'] = $this->selectRowsByCol(DbPrefix .'departments');
		$d['controlTypes'] = $this->selectRowsByCol(DbPrefix .'document_control_types');
		$d['Doc'] = $Doc;
		$d['title'] = 'Картка вихідного документа [ <b>'. $Doc->displayedNumber .'</b> ]';

		return $d;
	}

	/**
	 * @return incoming_documents_registry|false
	 */
	public function cardActionPage () {
		$Us = rg_Rg()->get('Us');
		$get = rg_Rg()->get('Get')->get;
		$post = rg_Rg()->get('Post')->post;
		$dbRow = $this->selectRowByCol(DbPrefix .'outgoing_documents_registry', 'odr_number', $get['n']);
		$Doc = new outgoing_documents_registry($dbRow['odr_id'], $dbRow);
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
			$dIdTitle = intval($post['dIdTitle']);

			if ($dIdTitle) {
				if ($dIdTitle !== $Doc->_id_title) $updated['odr_id_title'] = $dIdTitle;
			}

			$dDescription = intval($post['dDescription']);

			if ($dDescription) {
				if ($dDescription !== $Doc->_id_description) $updated['odr_id_description'] = $dDescription;
			}

			if ($post['dIncNumber']) {
				$newIncomingId = $this->selectCellByCol(DbPrefix .'incoming_documents_registry',
					'idr_number', substr($post['dIncNumber'], 4), 'idr_id');

				if (! $newIncomingId) {
					sess_addErrMessage('Не знайдено відповідний вихідний документ з номером <b>'.
						strval($post['dIncNumber']) .'</b>');

					return false;
				}

				if ($newIncomingId !== $Doc->_id_incoming_number) {
					$updated['odr_id_incoming_number'] = $newIncomingId;
				}
			}

			if ($post['dDate']) {
				$dt = tm_getDatetime($post['dDate'])->format('Y-m-d');

				if ($dt !== $Doc->_document_date) $updated['odr_document_date'] = $dt;
			}

			$dIdDocumentLocation = intval($post['dIdDocumentLocation']);

			if ($dIdDocumentLocation && ($dIdDocumentLocation !== $Doc->_id_document_location)) {
				$updated['odr_id_document_location'] = $dIdDocumentLocation;
			}

			$dIdSender = intval($post['dIdSender']);

			if ($dIdSender && ($dIdSender !== $Doc->_id_sender)) $updated['odr_id_sender'] = $dIdSender;

			$dIdRecipient = intval($post['dIdRecipient']);
			// dd([$dIdRecipient, $Doc->_id_recipient, $Doc], __FILE__, __LINE__,1);
			if ($dIdRecipient && ($dIdRecipient !== $Doc->_id_recipient)) {
				$updated['odr_id_recipient'] = $dIdRecipient;
			}

			if ($post['dDueDateBefore']) {
				$dt = tm_getDatetime($post['dDueDateBefore'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_control_date) $updated['odr_control_date'] = $dt;
			}

			$dIdControlType = intval($post['dIdControlType']);

			if ($dIdControlType && ($dIdControlType !== $Doc->_id_execution_control)) {
				$updated['odr_id_execution_control'] = $dIdControlType;
			}

			$dIdRresolution = intval($post['dIdRresolution']);

			if ($dIdRresolution && ($dIdRresolution !== $Doc->_id_resolution)) {
				$updated['odr_id_resolution'] = $dIdRresolution;
				$updated['odr_resolution_date'] = tm_getDatetime()->format('Y-m-d H:i:s');
			}
		}

		if ($isAdminRights) {
			$dIdRegistrar = intval($post['dIdRegistrar']);

			if ($dIdRegistrar && ($dIdRegistrar !== $Doc->_id_user)) {
				$updated['odr_id_user'] = $dIdRegistrar;
			}

			if ($post['dNumber']) {
				$newDocNumber = substr($post['dNumber'], 4);
				if ($newDocNumber !== $Doc->_number) $updated['odr_number'] = $newDocNumber;
			}

			if ($post['dIsReceivedExecutorUser'] && ! isset($updated['odr_date_of_receipt_by_executor'])) {
				$dt = tm_getDatetime($post['dIsReceivedExecutorUser'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_date_of_receipt_by_executor) {
					$updated['odr_date_of_receipt_by_executor'] = $dt;
				}
			}
		}

		if ($isSuperAdminRights) {
			if ($post['dRegistrationDate']) {
				$Dt = tm_getDatetime($post['dRegistrationDate']);
				$dtStr = $Dt->format('Y-m-d H:i:s');

				if ($dtStr !== $Doc->_add_date) $updated['odr_add_date'] = $dtStr;
			}
		}

		if ($updated) {
			if (! $Doc->update($updated)) return false;
		}

		return $Doc;
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
			$SQL->where('odr_number', 'like', '%'. $params['d_number'] .'%');
		}

		if (isset($params['d_age'])) {
			$SQL->whereRaw($SQL->raw('year(odr_document_date)') .' = "'.
				$params['d_age'] .'"');
		}

		if (isset($params['d_month'])) {
			$SQL->whereRaw($SQL->raw('month(odr_document_date)') .' = "'.
				$params['d_month'] .'"');
		}

		if (isset($params['d_day'])) {
			$SQL->whereRaw($SQL->raw('day(odr_document_date)') .' = "'.
				$params['d_day'] .'"');
		}

		if (isset($params['d_location'])) {
			$SQL
				->join(DbPrefix .'departments', 'dp_id', '=', 'odr_id_document_location')
				->where('odr_id_document_location', '=', $params['d_location']);
		}

		if (isset($params['d_recipient_external'])) {
			$SQL
				->join(DbPrefix .'document_senders', 'dss_id', '=', 'odr_id_recipient')
				->where('odr_id_recipient', '=', $params['d_recipient_external']);
		}

		if (isset($params['d_sender_user'])) {
			$orJoin['users'][] = 'us_id = odr_id_sender';
			$SQL->where('odr_id_sender', '=', $params['d_sender_user']);
		}

		if (isset($params['d_registrar_user'])) {
			$orJoin['users'][] = 'us_id = odr_id_user';
			$SQL->where('odr_id_user', '=', $params['d_registrar_user']);
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
}
