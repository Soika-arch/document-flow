<?php

namespace modules\df\models;

use \core\db_record\outgoing_documents_registry;
use \core\Get;
use \core\RecordSliceRetriever;
use \libs\Paginator;
use \libs\query_builder\SelectQuery;
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

		$SQLDocs = db_getSelect()
			->from(DbPrefix .'outgoing_documents_registry')
			->columns([DbPrefix .'outgoing_documents_registry.*'])
			->orderBy('odr_id');

		if (isset($_SESSION['getParameters'])) {
			if (! ($SQLDocs = $this->documentsSearchSQLHendler($SQLDocs))) return false;
		}

		$SQLDocs = new RecordSliceRetriever($SQLDocs);
		// dd($SQLDocs->SQL->prepare(), __FILE__, __LINE__,1);

		$itemsPerPage = 5;

		$d['documents'] = $SQLDocs->select($itemsPerPage, $pageNum);

		$url = url('/df/documents-outgoing/list?pg=(:num)');

		$Pagin = new Paginator($SQLDocs->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$Pagin->setMaxPagesToShow(5);

		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 * @return array
	 */
	public function cardPage () {
		$get = rg_Rg()->get('Get')->get;

		$dbRow = $this->selectRowByCol(
			DbPrefix .'outgoing_documents_registry', 'odr_number', $get['n']
		);

		$Doc = new outgoing_documents_registry($dbRow['odr_id'], $dbRow);

		$d['Doc'] = $Doc;
		$d['title'] = 'Картка вихідного документа [ <b>'. $Doc->displayedNumber .'</b> ]';

		return $d;
	}

	/**
	 * @return SelectQuery|false $SQL
	 */
	protected function documentsSearchSQLHendler (SelectQuery $SQL) {
		if (isset(rg_Rg()->get('Get')->get['clear'])) {
			sess_delGetParameters();

			return false;
		}

		$params = $_SESSION['getParameters'];
		$orJoin = [];

		if (isset($params['d_number'])) {
			$SQL->where('odr_number', 'like', '%'. $params['d_number'] .'%');
		}

		if (isset($params['d_age'])) {
			$SQL->whereRaw($SQL->raw('year(odr_document_date)') .' = "'.
				$params['d_age'] .'"');
		}

		if (isset($params['d_month'])) {
			$SQL->whereRaw($SQL->raw('month(odr_document_date)') .' = "'.
				$params['d_month'] .'"');
		}

		if (isset($params['d_day'])) {
			$SQL->whereRaw($SQL->raw('day(odr_document_date)') .' = "'.
				$params['d_day'] .'"');
		}

		if (isset($params['d_location'])) {
			$SQL
				->join(DbPrefix .'departments', 'dp_id', '=', 'odr_id_document_location')
				->where('odr_id_document_location', '=', $params['d_location']);
		}

		if (isset($params['d_recipient_external'])) {
			$SQL
				->join(DbPrefix .'document_senders', 'dss_id', '=', 'odr_id_recipient')
				->where('odr_id_recipient', '=', $params['d_recipient_external']);
		}

		if (isset($params['d_sender_user'])) {
			$orJoin['users'][] = 'us_id = odr_id_sender';
			$SQL->where('odr_id_sender', '=', $params['d_sender_user']);
		}

		if (isset($params['d_registrar_user'])) {
			$orJoin['users'][] = 'us_id = idr_id_user';
			$SQL->where('idr_id_user', '=', $params['d_registrar_user']);
		}

		if ($orJoin) {
			foreach ($orJoin as $table => $joinData) {
				$strJoin = '';

				foreach ($joinData as $condition) {
					$strJoin .= ' or '. $condition;
				}

				if (strpos($strJoin, ' or ') === 0) $strJoin = substr($strJoin, 4);

				$SQL->joinRaw(DbPrefix . $table, $strJoin);
			}
		}

		return $SQL;
	}
}
