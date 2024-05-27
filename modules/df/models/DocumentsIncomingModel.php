<?php

namespace modules\df\models;

use \core\db_record\incoming_documents_registry;
use \core\RecordSliceRetriever;
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
		$d['title'] = 'Вхідні документи - Список';

		$SQLDocs = db_getSelect()
			->from(DbPrefix .'incoming_documents_registry')
			->columns([DbPrefix .'incoming_documents_registry.*'])
			->orderBy('idr_id');

		if (isset($_SESSION['getParameters'])) {
			if (! ($SQLDocs = $this->documentsSearchSQLHendler($SQLDocs))) return false;
		}

		$SQLDocs = new RecordSliceRetriever($SQLDocs);
		// dd($SQLDocs->SQL->prepare(), __FILE__, __LINE__,1);
		$itemsPerPage = 5;

		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);

		$url = url('/df/documents-incoming/list?pg=(:num)');

		$Pagin = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);
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

		$dbRow = $this->selectRowByCol(
			DbPrefix .'incoming_documents_registry', 'idr_number', $incNumber
		);

		$Doc = new incoming_documents_registry($dbRow['idr_id'], $dbRow);

		/** @var bool якщо true, то користувач має права реєстратора на редагування. */
		$d['isRegistrarRights'] = (
			($Us->_id === $Doc->_id_user) || ($Us->_id === $Doc->ExecutorUser->_id)
		);

		/** @var bool якщо true, то користувач має права адміна на редагування. */
		$d['isAdminRights'] = ($Us->Status->_access_level < 3);

		$d['dTitles'] = $this->selectRowsByCol(DbPrefix .'document_titles');
		$d['users'] = $this->getDocumentFlowParticipants();
		$d['departaments'] = $this->selectRowsByCol(DbPrefix .'departments');
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
			if ($post['dIdTitle'] && $isRegistrarRights) {
				if (intval($post['dIdTitle']) !== $Doc->_id_title) $updated['idr_id_title'] = $post['dIdTitle'];
			}

			$dIdExecutorUser = intval($post['dIdExecutorUser']);

			if ($dIdExecutorUser && ($dIdExecutorUser !== $Doc->_id_assigned_user)) {
				$updated['idr_id_assigned_user'] = getArrayValue($post, 'dIdExecutorUser', null);
			}

			if ($post['dOutNumber']) {
				$newOutgoingId = $this->selectCellByCol(DbPrefix .'outgoing_documents_registry',
					'odr_number', substr($post['dOutNumber'], 4), 'odr_id');

				if ($newOutgoingId !== $Doc->_id_outgoing_number) {
					$updated['idr_id_outgoing_number'] = $newOutgoingId;
				}
			}

			if ($post['dDate']) {
				$dt = tm_getDatetime($post['dDate'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_document_date) $updated['idr_document_date'] = $dt;
			}

			$dIdDocumentLocation = intval($post['dIdDocumentLocation']);

			if ($dIdDocumentLocation && ($dIdDocumentLocation !== $Doc->_id_document_location)) {
				$updated['idr_id_document_location'] = getArrayValue($post, 'dIdDocumentLocation', null);
			}
		}

		if ($isAdminRights) {
			if ($post['dIdRegistrar'] && (intval($post['dIdRegistrar']) !== $Doc->_id_user)) {
				$updated['idr_id_user'] = getArrayValue($post, 'dIdRegistrar', null);
			}

			if ($post['dNumber']) {
				$newDocNumber = substr($post['dNumber'], 4);
				if ($newDocNumber !== $Doc->_number) $updated['idr_number'] = $newDocNumber;
			}

			if ($post['dIsReceivedExecutorUser']) {
				$dt = tm_getDatetime($post['dIsReceivedExecutorUser'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_date_of_receipt_by_executor) {
					$updated['idr_date_of_receipt_by_executor'] = $dt;
				}
			}
		}

		if ($isSuperAdminRights) {
			if ($post['dRegistrationDate']) {
				$dt = tm_getDatetime($post['dRegistrationDate'])->format('Y-m-d H:i:s');

				if ($dt !== $Doc->_add_date) $updated['idr_add_date'] = $dt;
			}
		}

		if ($updated) {
			if (! $Doc->update($updated)) return false;
		}

		return $Doc;
	}
}
