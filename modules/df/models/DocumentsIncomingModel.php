<?php

namespace modules\df\models;

use \core\db_record\incoming_documents_registry;
use \core\RecordSliceRetriever;
use \Doctrine\DBAL\ArrayParameterType;
use \Doctrine\DBAL\ParameterType;
use \libs\Paginator;
use \modules\df\models\MainModel;

/**
 * Модель вхідних документів.
 */
class DocumentsIncomingModel extends MainModel {

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
		$d['title'] = 'Вхідні документи - Головна';

		return $d;
	}

	/**
	 * @return array|false
	 */
	public function listPage (int $pageNum=1) {
		$d['title'] = 'Журнал вхідних документів';
		$tName = DbPrefix .'incoming_documents_registry';
		$colPx = db_Db()->getColPxByTableName($tName);

		$QB = db_DTSelect(DbPrefix .'incoming_documents_registry.*')
			->from($tName)
			->where('idr_trash_bin is :trashBin')
			->orderBy('idr_id')
			->setParameter('trashBin', null);

		if (isset($_SESSION['getParameters'])) {
			if (! ($QB = $this->documentsSearchSQLHendler($QB, $tName, $colPx))) return false;

			$QB->andWhere('idr_trash_bin is :trashBin')->setParameter('trashBin', null);
		}

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['documents'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/df/documents-incoming/list?pg=(:num)');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function cardPage () {
		$get = rg_Rg()->get('Get')->get;
		$Us = rg_Rg()->get('Us');
		$incNumber = $get['n'];
		// Номер сторінки коментарів.
		$cpn = isset($get['cpn']) ? $get['cpn'] : 1;

		$dbRow = $this->selectRowByCol(
			DbPrefix .'incoming_documents_registry', 'idr_number', $incNumber
		);

		$Doc = new incoming_documents_registry($dbRow['idr_id'], $dbRow);

		if ($Obj = $this->checkCardOpenedByExecutor($Doc)) $Doc = $Obj;

		$d['isRegistrarRights'] = $this->isRegistrarRights($Us, $Doc);
		$d['isAdminRights'] = $this->isAdminRights($Us);

		$d['documentTypes'] = $this->selectRowsByCol(DbPrefix .'document_types');
		$d['dTitles'] = $this->selectRowsByCol(DbPrefix .'document_titles');
		$d['descriptions'] = $this->selectRowsByCol(DbPrefix .'document_descriptions');
		$d['carrierTypes'] = $this->selectRowsByCol(DbPrefix .'document_carrier_types');
		$d['users'] = $this->getDocumentFlowParticipants();
		$d['senders'] = $this->selectRowsByCol(DbPrefix .'document_senders');
		$d['departments'] = $this->selectRowsByCol(DbPrefix .'departments');
		$d['controlTypes'] = $this->selectRowsByCol(DbPrefix .'document_control_types');
		$d['resolutions'] = $this->selectRowsByCol(DbPrefix .'document_resolutions');
		$d['Doc'] = $Doc;
		$d['title'] = 'Картка вхідного документа [ <b>'. $Doc->displayedNumber .'</b> ]';

		return $d;
	}

	/**
	 * @return incoming_documents_registry|false
	 */
	public function cardActionPage () {
		$Us = rg_Rg()->get('Us');
		$get = rg_Rg()->get('Get')->get;
		$post = rg_Rg()->get('Post')->post;
		$dbRow = $this->selectRowByCol(DbPrefix .'incoming_documents_registry', 'idr_number', $get['n']);
		$Doc = new incoming_documents_registry($dbRow['idr_id'], $dbRow);
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
					$updated['idr_id_document_type'] = $dIdDocumentType;
				}
			}

			$dIdTitle = intval($post['dIdTitle']);

			if ($dIdTitle) {
				if ($dIdTitle !== $Doc->_id_title) $updated['idr_id_title'] = $dIdTitle;
			}

			$dIdDescription = intval($post['dIdDescription']);

			if ($dIdDescription) {
				if ($dIdDescription !== $Doc->_id_description) {
					$updated['idr_id_description'] = $dIdDescription;
				}
			}

			$dIdCarrierType = intval($post['dIdCarrierType']);

			if ($dIdCarrierType) {
				if ($dIdCarrierType !== $Doc->_id_carrier_type) {
					$updated['idr_id_carrier_type'] = $dIdCarrierType;
				}
			}

			$dIdExecutorUser = intval($post['dIdExecutorUser']);

			if ($dIdExecutorUser && ($dIdExecutorUser !== $Doc->_id_assigned_user)) {
				$updated['idr_id_assigned_user'] = $dIdExecutorUser;
				$updated['idr_date_of_receipt_by_executor'] = null;
			}

			$dIdResponsibleUser = intval($post['dIdResponsibleUser']);

			if ($dIdResponsibleUser && ($dIdResponsibleUser !== $Doc->_id_responsible_user)) {
				$updated['idr_id_responsible_user'] = $dIdResponsibleUser;
			}

			$dIdResponsibleDepartament = intval($post['dIdResponsibleDepartament']);

			if ($dIdResponsibleDepartament &&
					($dIdResponsibleDepartament !== $Doc->_id_assigned_departament)) {
				$updated['idr_id_assigned_departament'] = $dIdResponsibleDepartament;
			}

			if ($post['dOutNumber']) {
				$newOutgoingId = $this->selectCellByCol(DbPrefix .'outgoing_documents_registry',
					'odr_number', substr($post['dOutNumber'], 4), 'odr_id');

				if (! $newOutgoingId) {
					sess_addErrMessage('Не знайдено відповідний вихідний документ з номером <b>'.
						strval($post['dOutNumber']) .'</b>', false);

					return false;
				}

				if ($newOutgoingId !== $Doc->_id_outgoing_number) {
					$updated['idr_id_outgoing_number'] = $newOutgoingId;
				}
			}

			if (isset($post['dDateDel']) && ($post['dDateDel'] === 'on')) {
				$updated['idr_document_date'] = null;
			}
			else if ($post['dDate']) {
				$dt = tm_getDatetime($post['dDate'])->format('Y-m-d');

				if ($dt !== $Doc->_document_date) $updated['idr_document_date'] = $dt;
			}

			$dIdDocumentLocation = intval($post['dIdDocumentLocation']);

			if ($dIdDocumentLocation && ($dIdDocumentLocation !== $Doc->_id_document_location)) {
				$updated['idr_id_document_location'] = $dIdDocumentLocation;
			}

			$dIdSender = intval($post['dIdSender']);

			if ($dIdSender && ($dIdSender !== $Doc->_id_sender)) $updated['idr_id_sender'] = $dIdSender;

			$dIdRecipient = intval($post['dIdRecipient']);

			if ($dIdRecipient && ($dIdRecipient !== $Doc->_id_recipient)) {
				$updated['idr_id_recipient'] = $dIdRecipient;
			}

			if (isset($post['dDueDateBeforeDel']) && ($post['dDueDateBeforeDel'] === 'on')) {
				$updated['idr_control_date'] = null;
			}
			else if ($post['dDueDateBefore']) {
				$dt = tm_getDatetime($post['dDueDateBefore'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_control_date) $updated['idr_control_date'] = $dt;
			}

			if (isset($post['dExecutionDateDel']) && ($post['dExecutionDateDel'] === 'on')) {
				$updated['idr_execution_date'] = null;
			}
			else if ($post['dExecutionDate']) {
				$dt = tm_getDatetime($post['dExecutionDate'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_control_date) $updated['idr_execution_date	'] = $dt;
			}

			$dIdControlType = intval($post['dIdControlType']);

			if ($dIdControlType && ($dIdControlType !== $Doc->_id_execution_control)) {
				$updated['idr_id_execution_control'] = $dIdControlType;
			}

			if (($post['dIdRresolution'] === '') && $Doc->_id_resolution) {
				$updated['idr_id_resolution'] = null;
				$updated['idr_resolution_date'] = null;
			}
			else {
				$dIdRresolution = intval($post['dIdRresolution']);

				if ($dIdRresolution && ($dIdRresolution !== $Doc->_id_resolution)) {
					$updated['idr_id_resolution'] = $dIdRresolution;
					$updated['idr_resolution_date'] = tm_getDatetime()->format('Y-m-d H:i:s');
				}
			}
		}

		if ($isAdminRights) {
			$dIdRegistrar = intval($post['dIdRegistrar']);

			if ($dIdRegistrar && ($dIdRegistrar !== $Doc->_id_user)) {
				$updated['idr_id_user'] = $dIdRegistrar;
			}

			if ($post['dNumber']) {
				$newDocNumber = substr($post['dNumber'], 4);
				if ($newDocNumber !== $Doc->_number) $updated['idr_number'] = $newDocNumber;
			}

			if (isset($post['dIsReceivedExecutorUserDel']) &&
					($post['dIsReceivedExecutorUserDel'] === 'on')) {
				$updated['idr_date_of_receipt_by_executor'] = null;
			}
			else if ($post['dIsReceivedExecutorUser'] && ! isset($updated['idr_date_of_receipt_by_executor'])) {
				$dt = tm_getDatetime($post['dIsReceivedExecutorUser'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_date_of_receipt_by_executor) {
					$updated['idr_date_of_receipt_by_executor'] = $dt;
				}
			}
		}

		if ($isSuperAdminRights) {
			if ($post['dRegistrationDate']) {
				$Dt = tm_getDatetime($post['dRegistrationDate']);
				$dtStr = $Dt->format('Y-m-d H:i:s');

				if ($dtStr !== $Doc->_add_date) $updated['idr_add_date'] = $dtStr;
			}
		}

		if ($updated) {
			if (! $Doc->update($updated)) return false;

			if (isset($updated['idr_id_assigned_user'])) {
				if ($this->informAboutAppointmentAsExecutor($updated['idr_id_assigned_user'], $Doc)) {
					sess_addSysMessage('Виконавцю відправлено повідомлення про призначення документа');
				}
			}
		}

		return $Doc;
	}

	/**
	 * @return int|string The number of affected rows.
	 */
	public function toTrashBinDocuments () {
		$Post = rg_Rg()->get('Post');

		$sql = 'UPDATE '. DbPrefix .
			'incoming_documents_registry SET idr_trash_bin = ? WHERE idr_id IN (?)';

		/** @var \Doctrine\DBAL\Connection */
		$Conn = db_Db()->DTConnection;

		return $Conn->executeStatement(
			$sql,
			[date('Y-m-d H:i:s'), $Post->post['docsId']],
			[ParameterType::STRING, ArrayParameterType::INTEGER]
		);
	}
}
