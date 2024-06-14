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
	public function r0004Page (int $pageNum=1) {
		$d['title'] = 'Виконані вхідні документи';

		$SQLDocs = db_getSelect()
			->columns([DbPrefix .'incoming_documents_registry.*'])
			->from(DbPrefix .'incoming_documents_registry')
			->where('idr_execution_date', '!=', null)
			->orderBy('idr_id');

		$SQLDocs = new RecordSliceRetriever($SQLDocs);
		$itemsPerPage = 5;
		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0004?pn=(:num)#pagin');
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
		$tName = DbPrefix .'internal_documents_registry';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->where('inr_execution_date = :executionDate')
			->setParameter('executionDate', null)
			->orderBy('inr_id');

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['documents'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0001?pn=(:num)');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function r0005Page (int $pageNum=1) {
		$d['title'] = 'Виконані внутрішні документи';

		$SQLDocs = db_getSelect()
			->columns([DbPrefix .'internal_documents_registry.*'])
			->from(DbPrefix .'internal_documents_registry')
			->where('inr_execution_date', '!=', null)
			->orderBy('inr_id');

		$SQLDocs = new RecordSliceRetriever($SQLDocs);
		$itemsPerPage = 5;
		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0005?pn=(:num)#pagin');
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

		$docTable = DbPrefix .'incoming_documents_registry';
		$itemsPerPage = 5;
		$offset = ($itemsPerPage * 2) - $itemsPerPage;

		$QB = db_DTSelect(DbPrefix .'users.*')
			->from(DbPrefix .'users')
			->innerJoin(DbPrefix .'users', $docTable, 'idr', 'idr_id_assigned_user = us_id')
			->where('idr_execution_date is null')
			->orderBy('us_id')
			->setFirstResult($offset)
			->setMaxResults($itemsPerPage);

		$QBSlice = new RecordSliceRetriever($QB);

		$d['users'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0003?pn=(:num)');
		$d['Pagin'] = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$d['Pagin']->setMaxPagesToShow(5);

		return $d;
	}

	/**
	 * Звіт по вхідним документам на контролі.
	 * @return array
	 */
	public function r0006Page (int $pageNum=1) {
		$d['title'] = 'Вхідні документи на контролі';
		$tName = DbPrefix .'incoming_documents_registry';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->where('idr_id_execution_control is not :idExecutionControl')
			->orderBy('idr_id')
			->setParameter('idExecutionControl', null);

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['documents'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0006?pn=(:num)#pagin');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * Звіт по внутрішнім документам на контролі.
	 * @return array
	 */
	public function r0007Page (int $pageNum=1) {
		$d['title'] = 'Внутрішні документи на контролі';

		$SQLDocs = db_getSelect()
			->columns([DbPrefix .'internal_documents_registry.*'])
			->from(DbPrefix .'internal_documents_registry')
			->where('inr_id_execution_control', '!=', null)
			->orderBy('inr_id');

		$SQLDocs = new RecordSliceRetriever($SQLDocs);
		$itemsPerPage = 5;
		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0007?pn=(:num)#pagin');
		$Pagin = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * Виконавці, які не виконали внутрішні документи.
	 * @return array
	 */
	public function r0008Page (int $pageNum=1) {
		$d['title'] = 'Виконавці, які не виконали документи';
		$tName = DbPrefix .'users';

		$docTable = DbPrefix .'internal_documents_registry';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->join($tName, $docTable, 'inr', 'inr_id_assigned_user = us_id')
			->where('inr_execution_date = :executionDate')
			->setParameter('executionDate', null)
			->orderBy('us_id');

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['users'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0008?pn=(:num)');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}
}
