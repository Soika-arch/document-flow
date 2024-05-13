<?php

namespace modules\df\models;

use \core\db_record\document_types;
use \modules\df\models\MainModel;
use \core\Post;
use \core\RecordSliceRetriever;
use \libs\Paginator;

/**
 * Модель типів документів.
 */
class DocumentRegistrationModel extends MainModel {

	/**
	 *
	 */
	public function __construct () {
		parent::__construct();
	}

	public function incomingPage () {
		$d = [];

		$SQL = db_getSelect();

		$SQL
			->columns(['*'])
			->from([DbPrefix .'document_types']);

		$d['dt'] = db_select($SQL);

		return $d;
	}
}
