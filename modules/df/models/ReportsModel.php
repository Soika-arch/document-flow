<?php

namespace modules\df\models;

use \core\RecordSliceRetriever;
use \libs\Paginator;
use \modules\df\models\MainModel;

/**
 * Модель звітів документів.
 */
class ReportsModel extends MainModel {

	/**
	 * @return array
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * @return array
	 */
	public function mainPage () {
		$d['title'] = 'Звіти';

		return $d;
	}

	/**
	 * @return array
	 */
	public function r0001Page (int $pageNum=1) {
		$d['title'] = 'Невиконані вхідні документи';

		$SQLDocs = db_getSelect()
			->columns([DbPrefix .'incoming_documents_registry.*'])
			->from(DbPrefix .'incoming_documents_registry')
			->where('idr_execution_date', '=', null)
			->orderBy('idr_id');

		$SQLDocs = new RecordSliceRetriever($SQLDocs);
		$itemsPerPage = 5;
		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0001?pn=(:num)');
		$Pagin = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function r0002Page (int $pageNum=1) {
		$d['title'] = 'Невиконані внутрішні документи';

		$SQLDocs = db_getSelect()
			->columns([DbPrefix .'internal_documents_registry.*'])
			->from(DbPrefix .'internal_documents_registry')
			->where('inr_execution_date', '=', null)
			->orderBy('inr_id');

		$SQLDocs = new RecordSliceRetriever($SQLDocs);
		$itemsPerPage = 5;
		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0001?pn=(:num)');
		$Pagin = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function r0003Page (int $pageNum=1) {
		$d['title'] = 'Виконавці, які не виконали документи';

		$SQLUs = db_getSelect();

		$docTable = DbPrefix .'incoming_documents_registry';

		$SQLUs->distinct()
			->columns([DbPrefix .'users.*'])
			->from(DbPrefix .'users')
			->join($docTable, 'idr_id_assigned_user', '=', 'us_id')
			->where('idr_execution_date', '=', null)
			->orderBy('us_id');

		$SQLUs = new RecordSliceRetriever($SQLUs);
		$itemsPerPage = 5;
		$d['users'] = $SQLUs->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0003?pn=(:num)');
		$Pagin = new Paginator($SQLUs->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}
}
