<?php

namespace modules\ap\controllers;

use \core\Get;
use \modules\ap\controllers\MainController;
use \modules\ap\models\SecurityModel;

/**
 * Контроллер адмін-панелі управління безпекою сайта.
 */
class SecurityController extends MainController {

	private SecurityModel $Model;

	public function __construct () {
		$this->Model = $this->get_Model();
	}

	/**
	 * Ініціалізує та повертає властивість $this->allowedStatuses.
	 */
	private function get_allowedStatuses () {
		if (! isset($this->allowedStatuses)) {
			$this->allowedStatuses = ['SuperAdmin'];
		}

		return $this->allowedStatuses;
	}

	public function mainPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$d = $this->Model->mainPage();

		require $this->getViewFile('security/main');
	}

	public function visitsListPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'pn' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			]
		]);

		$pageNum = isset($Get->get['pn']) ? $Get->get['pn'] : 1;

		$d = $this->Model->visitsListPage($pageNum);

		require $this->getViewFile('security/visits_list');
	}
}
