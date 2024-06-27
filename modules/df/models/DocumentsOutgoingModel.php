<?php

namespace modules\df\models;

use \core\db_record\outgoing_documents_registry;
use \core\RecordSliceRetriever;
use \Doctrine\DBAL\ArrayParameterType;
use \Doctrine\DBAL\ParameterType;
use \libs\Paginator;
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
		$d['title'] = 'Журнал вихідних документів';
		$tName = DbPrefix .'outgoing_documents_registry';
		$colPx = db_Db()->getColPxByTableName($tName);

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->where('odr_trash_bin is :trashBin')
			->orderBy('odr_id')
			->setParameter('trashBin', null);

		if (isset($_SESSION['getParameters'])) {
			if (! ($QB = $this->documentsSearchSQLHendler($QB, $tName, $colPx))) return false;

			$QB->andWhere('odr_trash_bin is :trashBin')->setParameter('trashBin', null);
		}

		$QBSlice = new RecordSliceRetriever($QB);
		// dd($QBSlice->SQL->prepare(), __FILE__, __LINE__,1);

		$itemsPerPage = 5;

		$d['documents'] = $QBSlice->select($itemsPerPage, $pageNum);

		$url = url('/df/documents-outgoing/list?pg=(:num)');

		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);

		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return int|string The number of affected rows.
	 */
	public function toTrashBinDocuments () {
		$Post = rg_Rg()->get('Post');

		$sql = 'UPDATE '. DbPrefix .
			'outgoing_documents_registry SET odr_trash_bin = ? WHERE odr_id IN (?)';

		/** @var \Doctrine\DBAL\Connection */
		$Conn = db_Db()->DTConnection;

		return $Conn->executeStatement(
			$sql,
			[date('Y-m-d H:i:s'), $Post->post['docsId']],
			[ParameterType::STRING, ArrayParameterType::INTEGER]
		);
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

		if ($Obj = $this->checkCardOpenedByExecutor($Doc)) $Doc = $Obj;

		$d['isRegistrarRights'] = $this->isRegistrarRights($Us, $Doc);
		$d['isAdminRights'] = $this->isAdminRights($Us);

		$d['documentTypes'] = $this->selectRowsByCol(DbPrefix .'document_types');
		$d['dTitles'] = $this->selectRowsByCol(DbPrefix .'document_titles');
		$d['dTitles'] = $this->selectRowsByCol(DbPrefix .'document_titles');
		$d['descriptions'] = $this->selectRowsByCol(DbPrefix .'document_descriptions');
		$d['carrierTypes'] = $this->selectRowsByCol(DbPrefix .'document_carrier_types');
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
			$dIdDocumentType = intval($post['dIdDocumentType']);

			if ($dIdDocumentType) {
				if ($dIdDocumentType !== $Doc->_id_document_type) {
					$updated['odr_id_document_type'] = $dIdDocumentType;
				}
			}

			$dIdTitle = intval($post['dIdTitle']);

			if ($dIdTitle) {
				if ($dIdTitle !== $Doc->_id_title) $updated['odr_id_title'] = $dIdTitle;
			}

			$dIdDescription = intval($post['dIdDescription']);

			if ($dIdDescription) {
				if ($dIdDescription !== $Doc->_id_description) {
					$updated['odr_id_description'] = $dIdDescription;
				}
			}

			$dIdCarrierType = intval($post['dIdCarrierType']);

			if ($dIdCarrierType) {
				if ($dIdCarrierType !== $Doc->_id_carrier_type) {
					$updated['odr_id_carrier_type'] = $dIdCarrierType;
				}
			}

			if (isset($post['dIncNumber']) && $post['dIncNumber']) {
				$newIncomingId = $this->selectCellByCol(DbPrefix .'incoming_documents_registry',
					'idr_number', substr($post['dIncNumber'], 4), 'idr_id');

				if (! $newIncomingId) {
					sess_addErrMessage('Не знайдено відповідний вихідний документ з номером <b>'.
						strval($post['dIncNumber']) .'</b>', false);

					return false;
				}

				if ($newIncomingId !== $Doc->_id_incoming_number) {
					$updated['odr_id_incoming_number'] = $newIncomingId;
				}
			}

			if (isset($post['dRegistrationFormNumber']) && $post['dRegistrationFormNumber']) {
				if ($post['dRegistrationFormNumber'] !== $Doc->_registration_form_number) {
					$updated['odr_registration_form_number'] = $post['dRegistrationFormNumber'];
				}
			}

			if (isset($post['dDateDel']) && ($post['dDateDel'] === 'on')) {
				$updated['odr_document_date'] = null;
			}
			else if ($post['dDate']) {
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

			if ($dIdRecipient && ($dIdRecipient !== $Doc->_id_recipient)) {
				$updated['odr_id_recipient'] = $dIdRecipient;
			}

			if (isset($post['dDueDateBeforeDel']) && ($post['dDueDateBeforeDel'] === 'on')) {
				$updated['odr_control_date'] = null;
			}
			else if ($post['dDueDateBefore']) {
				$dt = tm_getDatetime($post['dDueDateBefore'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_control_date) $updated['odr_control_date'] = $dt;
			}

			$dIdControlType = intval($post['dIdControlType']);

			if ($dIdControlType && ($dIdControlType !== $Doc->_id_execution_control)) {
				$updated['odr_id_execution_control'] = $dIdControlType;
			}

			if (isset($post['dExecutionDateDel']) && ($post['dExecutionDateDel'] === 'on')) {
				$updated['odr_execution_date'] = null;
			}
			else if ($post['dExecutionDate']) {
				$dt = tm_getDatetime($post['dExecutionDate'])->format('Y-m-d');

				if ($dt !== $Doc->_execution_date) $updated['odr_execution_date'] = $dt;
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
}
