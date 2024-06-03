<?php

namespace modules\df\controllers;

use \core\Get;
use \modules\df\controllers\MainController as MC;
use \modules\df\models\ReportsModel;

/**
 * Контроллер пошуку документів.
 */
class ReportsController extends MC {

	private ReportsModel $Model;

	public function __construct () {
		$this->Model = $this->get_Model();
	}

	/**
	 * Ініціалізує та повертає властивість $this->allowedStatuses.
	 */
	private function get_allowedStatuses () {
		if (! isset($this->allowedStatuses)) {
			$this->allowedStatuses = ['Admin', 'SuperAdmin'];
		}

		return $this->allowedStatuses;
	}

	public function mainPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$d = $this->Model->mainPage();

		require $this->getViewFile('reports/main');
	}

	/**
	 * Звіт по невиконаним вхідним документам.
	 */
	public function r0001Page () {
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

		$d = $this->Model->r0001Page($pageNum);

		require $this->getViewFile('reports/r0001');
	}

	/**
	 * Звіт по невиконаним внутрішнім документам.
	 */
	public function r0002Page () {
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

		$d = $this->Model->r0002Page($pageNum);

		require $this->getViewFile('reports/r0002');
	}

	/**
	 * Звіт по виконавцім, які не виконали документи.
	 */
	public function r0003Page () {
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

		$d = $this->Model->r0003Page($pageNum);

		require $this->getViewFile('reports/r0003');
	}
}
