<?php

namespace modules\df\models;

use \core\models\MainModel as MM;
use \core\RecordSliceRetriever;
use \libs\Paginator;

/**
 * Модель типів документів.
 */
class MainModel extends MM {

	/**
	 *
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 *
	 */
	public function mainPage () {
		$args = funcGetArgs(func_get_args());
		$pageNum = isset($args['pageNum']) ? $args['pageNum'] : 1;
		$mode = isset($args['mode']) ? $args['mode'] : 'inc';
		$d['title'] = 'ЕД';

		$tables = [
			'inc' => ['tName' => 'incoming_documents_registry', 'controllerURI' => 'documents-incoming'],
			'out' => ['tName' => 'outgoing_documents_registry', 'controllerURI' => 'documents-outgoing'],
			'int' => ['tName' => 'internal_documents_registry', 'controllerURI' => 'documents-internal']
		];

		$d['controllerURI'] = $tables[$mode]['controllerURI'];
		$d['px'] = db_Db()->getColPxByTableName(DbPrefix . $tables[$mode]['tName']);

		$SQLDocs = (new RecordSliceRetriever())
			->from(DbPrefix . $tables[$mode]['tName'])
			->columns([DbPrefix . $tables[$mode]['tName'] .'.*'])
			->orderBy($d['px'] .'add_date');

		$itemsPerPage = 5;

		$d['tableName'] = $tables[$mode]['tName'];
		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);

		$url = url('/df?mode='. $mode .'&pg=(:num)');

		$d['Pagin'] = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);

		return $d;
	}

	/**
	 * @param int $pageNum
	 * @return array
	 */
	public function listPage (int $pageNum=1) {
		$SQLDt = (new RecordSliceRetriever())
			->from(DbPrefix .'document_types')
			->columns(['dt_id', 'dt_name'])
			->orderBy('dt_id');

		$itemsPerPage = 5;

		$d['dt'] = $SQLDt->select($itemsPerPage, $pageNum);

		$d['Pagin'] = new Paginator($SQLDt->getRowsCount(), $itemsPerPage, $pageNum);

		return $d;
	}
}
