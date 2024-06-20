<?php

namespace modules\ap\models;

use \modules\ap\models\MainModel;
use \core\RecordSliceRetriever;
use \libs\Paginator;

/**
 * Модель адмін-панелі управління безпекою сайта.
 */
class SecurityModel extends MainModel {

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
		$d['title'] = 'Адмін-панель - безпека';

		return $d;
	}

	/**
	 * @param int $pageNum
	 * @return array
	 */
	public function visitsListPage (int $pageNum=1) {
		$d['title'] = 'Адмін-панель - відвідувачі';
		$tName = DbPrefix .'visitor_routes';

		$QB = db_DTSelect($tName .'.*')
			->from($tName)
			->orderBy('vr_add_date', 'desc');

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 20;
		$d['visitors'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/ap/security/visits-list?pn=(:num)#pagin');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);

		$d['Pagin'] = $Pagin;

		return $d;
	}
}
