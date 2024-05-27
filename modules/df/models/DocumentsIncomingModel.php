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
		$d['users'] = $this->selectRowsByCol(DbPrefix .'users', 'us_id', '0', [], '>');
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

		if ($post['dIdTitle'] && ($Us->Status->_access_level < 4)) {
			if (intval($post['dIdTitle']) !== $Doc->_id_title) $updated['idr_id_title'] = $post['dIdTitle'];
		}

		if ($post['dIdExecutorUser'] && (intval($post['dIdExecutorUser']) !== $Doc->_id_assigned_user)) {
			$updated['idr_id_assigned_user'] = getArrayValue($post, 'dIdExecutorUser', null);
		}

		if ($post['dOutNumber']) {
			$newOutgoingId = $this->selectCellByCol(DbPrefix .'outgoing_documents_registry',
				'odr_number', substr($post['dOutNumber'], 4), 'odr_id');

			if (($Doc->Registrar->Status->_access_level < 3) ||
					($Doc->Registrar->_id === $Us->_id)) {
				$updated['idr_id_outgoing_number'] = $newOutgoingId;
			}
		}

		// Дані, які дозволено змінювати адміну.
		if ($Us->Status->_access_level < 3) {
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

		if ($updated) {
			if (! $Doc->update($updated)) return false;
		}

		return $Doc;
	}
}
