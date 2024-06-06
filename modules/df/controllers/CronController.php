<?php

namespace modules\df\controllers;

use \modules\df\controllers\MainController as MC;
use \modules\df\models\CronModel;

/**
 * Контроллер пошуку документів.
 */
class CronController extends MC {

	private CronModel $Model;

	public function __construct () {
		$this->Model = new CronModel();
	}

	/**
	 * Ініціалізує та повертає властивість $this->allowedStatuses.
	 */
	private function get_allowedStatuses () {
		if (! isset($this->allowedStatuses)) {
			$this->allowedStatuses = ['Guest', 'Viewer', 'User', 'Admin', 'SuperAdmin'];
		}

		return $this->allowedStatuses;
	}

	/**
	 *
	 */
	public function mainPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$this->Model->mainPage();
	}

	public function t0001 () {
		$this->Model->notifyAboutControlDate();
	}

	public function t0002 () {
		$this->Model->notifyAboutUnreadMessages();
	}
}
