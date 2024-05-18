<?php

namespace modules\df\models;

use core\RecordSliceRetriever;
use libs\Paginator;
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
	 * @return array
	 */
	public function listPage (int $pageNum=1) {
		$d['title'] = 'Вхідні документи - Список';

		$SQLId = (new RecordSliceRetriever())
			->from(DbPrefix .'incoming_documents_registry')
			->columns([DbPrefix .'incoming_documents_registry.*'])
			->orderBy('idr_id');

		$itemsPerPage = 10;

		$d['documents'] = $SQLId->select($itemsPerPage, $pageNum);

		$url = url('/df/document-types/list?pg=(:num)');

		$Pagin = new Paginator($SQLId->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);

		$d['Pagin'] = $Pagin;

		return $d;
	}
}
