<?php

namespace modules\df\controllers;

use \core\controllers\CronController as CC;
use \modules\df\models\CronModel;

/**
 * Контроллер пошуку документів.
 */
class CronController extends CC {

	private CronModel $Model;

	public function __construct () {
		$this->Model = new CronModel();
	}

	public function t0001 () {
		$this->Model->notifyAboutControlDate();
	}

	public function t0002 () {
		$this->Model->notifyAboutUnreadMessages();
	}

	public function t0003 () {
		$this->Model->backupOfDatabaseTables();
	}

	public function t0003Page () {
		$this->Model->backupOfDatabaseTables();
	}
}
