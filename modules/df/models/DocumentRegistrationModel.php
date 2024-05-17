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

		$d['documentTypes'] = $this->selectRowsByCol(DbPrefix .'document_types');
		$d['carrierTypes'] = $this->selectRowsByCol(DbPrefix .'document_carrier_types');
		$d['documentStatuses'] = $this->selectRowsByCol(DbPrefix .'document_statuses');
		$d['assignedDepartaments'] = $this->selectRowsByCol(DbPrefix .'departments');
		$d['resolutions'] = $this->selectRowsByCol(DbPrefix .'document_resolutions');
		$d['documentControlTypes'] = $this->selectRowsByCol(DbPrefix .'document_control_types');

		return $d;
	}
}
