<?php

namespace modules\df\models;

use \core\db_record\outgoing_documents_registry;
use \core\Get;
use \core\RecordSliceRetriever;
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
		$d['title'] = 'Вихідні документи - Список';

		$SQLId = (new RecordSliceRetriever())
			->from(DbPrefix .'outgoing_documents_registry')
			->columns([DbPrefix .'outgoing_documents_registry.*'])
			->orderBy('odr_id');

		$itemsPerPage = 5;

		$d['documents'] = $SQLId->select($itemsPerPage, $pageNum);

		$url = url('/df/documents-outgoing/list?pg=(:num)');

		$Pagin = new Paginator($SQLId->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);

		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function cardPage (Get $Get) {
		$incNumber = 'out_'. $Get->get['n'];

		$dbRow = $this->selectRowByCol(
			DbPrefix .'outgoing_documents_registry', 'odr_number', $incNumber
		);

		$Doc = new outgoing_documents_registry($dbRow['odr_id'], $dbRow);

		$d['Doc'] = $Doc;
		$d['title'] = 'Картка вихідного документа [ <b>'. strtoupper($incNumber) .'</b> ]';

		return $d;
	}
}
