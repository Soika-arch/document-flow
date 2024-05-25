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
			'del_doc' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'pg' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'clear' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^y$'
			],
		]);

		if ($Get->errors) dd($Get->errors, __FILE__, __LINE__,1);

		$pageNum = isset($Get->get['pg']) ? $Get->get['pg'] : 1;

		$d = $this->Model->mainPage('pageNum:'. $pageNum);

		if (! $d) hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);

		require $this->getViewFile('main');
	}
}
