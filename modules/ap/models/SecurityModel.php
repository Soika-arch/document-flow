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

		$SQL = (new RecordSliceRetriever())
			->from(DbPrefix .'visitor_routes')
			->columns([DbPrefix .'visitor_routes.*'])
			->orderBy('vr_add_date desc');

		$itemsPerPage = 20;

		$d['visitors'] = $SQL->select($itemsPerPage, $pageNum);

		$url = url('/ap/security/visits-list?pn=(:num)#pagin');

		$Pagin = new Paginator($SQL->getRowsCount(), $itemsPerPage, $pageNum, $url);

		$d['Pagin'] = $Pagin;

		return $d;
	}
}
