<?php

namespace modules\ap\models;

use \core\RecordSliceRetriever;
use \libs\Paginator;
use \modules\df\models\MainModel;

/**
 * Модель управління cron задачами.
 */
class CronsModel extends MainModel {

	/**
	 *
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * @return array
	 */
	public function mainPage () {
		$d['title'] = 'Crons';

		return $d;
	}

	/**
	 * @return array
	 */
	public function listPage (int $pageNum=1) {
		$d['title'] = 'Crons - список';
		$tName = DbPrefix .'cron_tasks';

		$QB = db_DTSelect($tName .'.*')
			->from($tName);

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['crons'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/ap/crons/list?pg=(:num)#pagin');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$d['Pagin'] = $Pagin;

		return $d;
	}
}
