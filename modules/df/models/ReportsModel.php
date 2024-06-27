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
		$tName = DbPrefix .'incoming_documents_registry';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->where('idr_execution_date is :executionDate and idr_trash_bin is :trashBin')
			->orderBy('idr_id')
			->setParameter('executionDate', null)
			->setParameter('trashBin', null);

		$SQLDocs = new RecordSliceRetriever($QB);
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
		$tName = DbPrefix .'incoming_documents_registry';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->where('idr_execution_date is not :executionDate and idr_trash_bin is :trashBin')
			->orderBy('idr_id')
			->setParameter('executionDate', null)
			->setParameter('trashBin', null);

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['documents'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0004?pn=(:num)#pagin');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
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
			->where('inr_execution_date is :executionDate and inr_trash_bin is :trashBin')
			->orderBy('inr_id')
			->setParameter('executionDate', null)
			->setParameter('trashBin', null);

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
		$tName = DbPrefix .'internal_documents_registry';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->where('inr_execution_date is not :executionDate and inr_trash_bin is :trashBin')
			->orderBy('inr_id')
			->setParameter('executionDate', null)
			->setParameter('trashBin', null);

		$SQLDocs = new RecordSliceRetriever($QB);
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
		$d['title'] = 'Виконавці, які не виконали вхідні документи';
		$tName = DbPrefix .'users';
		$docTable = DbPrefix .'incoming_documents_registry';
		$itemsPerPage = 5;
		$offset = ($itemsPerPage * 2) - $itemsPerPage;

		$QB = db_DTSelect($tName .'.*')
			->distinct()
			->from($tName)
			->innerJoin(DbPrefix .'users', $docTable, 'idr', 'idr_id_assigned_user = us_id')
			->where('idr_execution_date is null and idr_trash_bin is :trashBin')
			->orderBy('us_id')
			->setFirstResult($offset)
			->setMaxResults($itemsPerPage)
			->setParameter('trashBin', null);

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
			->where('idr_id_execution_control is not :idExecutionControl'.
				' and idr_trash_bin is :trashBin')
			->orderBy('idr_id')
			->setParameter('idExecutionControl', null)
			->setParameter('trashBin', null);

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
		$tName = DbPrefix .'internal_documents_registry';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->where('inr_id_execution_control is not :idExecutionControl'.
				' and inr_trash_bin is :trashBin')
			->orderBy('inr_id')
			->setParameter('idExecutionControl', null)
			->setParameter('trashBin', null);

		$SQLDocs = new RecordSliceRetriever($QB);
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
		$d['title'] = 'Виконавці, які не виконали внутрішні документи';
		$tName = DbPrefix .'users';

		$docTable = DbPrefix .'internal_documents_registry';

		$QB = db_DTSelect($tName .'.*')
			->distinct()
			->from($tName)
			->join($tName, $docTable, 'inr', 'inr_id_assigned_user = us_id')
			->where('inr_execution_date is :executionDate and inr_trash_bin is :trashBin')
			->orderBy('us_id')
			->setParameter('executionDate', null)
			->setParameter('trashBin', null);

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['users'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0008?pn=(:num)');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function r0009Page (int $pageNum=1) {
		$d['title'] = 'Прострочені вхідні документи';
		$tName = DbPrefix .'incoming_documents_registry';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->where('idr_execution_date is :executionDate and date(idr_control_date) < :nowDate and idr_trash_bin is :trashBin')
			->orderBy('idr_id')
			->setParameter('executionDate', null)
			->setParameter('nowDate', date('Y-m-d'))
			->setParameter('trashBin', null);

		$SQLDocs = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0009?pn=(:num)');
		$Pagin = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function r0010Page (int $pageNum=1) {
		$d['title'] = 'Прострочені внутрішні документи';
		$tName = DbPrefix .'internal_documents_registry';
		$nowDt = date('Y-m-d');

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->where('(inr_execution_date is :executionDateNull'.
				' or date(inr_execution_date) < :executionDate)'.
				' and date(inr_control_date) < :nowDate and inr_trash_bin is :trashBin')
			->orderBy('inr_id')
			->setParameter('executionDateNull', null)
			->setParameter('executionDate', $nowDt)
			->setParameter('nowDate', $nowDt)
			->setParameter('trashBin', null);

		$SQLDocs = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);
		$url = url('/df/reports/r0010?pn=(:num)');
		$Pagin = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);
		$d['Pagin'] = $Pagin;

		return $d;
	}
}
