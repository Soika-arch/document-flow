<?php

namespace modules\df\controllers;

use \core\controllers\MainController as MC;
use \core\Get;
use \modules\df\models\MainModel;

/**
 * Контроллер типів документів.
 */
class MainController extends MC {

	private MainModel $Model;

	public function __construct () {
		$this->Model = $this->get_Model();
	}

	/**
	 * Ініціалізує та повертає властивість $this->allowedStatuses.
	 */
	private function get_allowedStatuses () {
		if (! isset($this->allowedStatuses)) {
			$this->allowedStatuses = ['Viewer', 'User', 'Admin', 'SuperAdmin'];
		}

		return $this->allowedStatuses;
	}

	public function mainPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'mode' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(inc)|(out)|(int)$'
			],
			'pg' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
		]);

		$pageNum = isset($_GET['pg']) ? $Get->get['pg'] : 1;
		$mode = isset($_GET['mode']) ? $Get->get['mode'] : 'inc';

		$d = $this->Model->mainPage($pageNum, $mode);

		require $this->getViewFile('main');
	}
}
