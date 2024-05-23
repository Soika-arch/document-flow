<?php

namespace modules\df\models;

use \core\db_record\internal_documents_registry;
use \core\Get;
use \core\RecordSliceRetriever;
use \libs\Paginator;
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

		$SQLId = (new RecordSliceRetriever())
			->from(DbPrefix .'internal_documents_registry')
			->columns([DbPrefix .'internal_documents_registry.*'])
			->orderBy('inr_id');

		$itemsPerPage = 5;

		$d['documents'] = $SQLId->select($itemsPerPage, $pageNum);

		$url = url('/df/documents-internal/list?pg=(:num)');

		$Pagin = new Paginator($SQLId->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);

		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function cardPage (Get $Get) {
		$docNumber = 'int_'. $Get->get['n'];

		$dbRow = $this->selectRowByCol(
			DbPrefix .'internal_documents_registry', 'inr_number', $docNumber
		);

		$Doc = new internal_documents_registry($dbRow['inr_id'], $dbRow);

		$d['Doc'] = $Doc;
		$d['title'] = 'Картка внутрішнього документа [ <b>'. strtoupper($docNumber) .'</b> ]';

		return $d;
	}
}
