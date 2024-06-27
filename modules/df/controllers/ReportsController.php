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
			$this->allowedStatuses = ['Viewer', 'User', 'Admin', 'SuperAdmin'];
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
	 * Звіт по виконаним вхідним документам.
	 */
	public function r0004Page () {
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

		$d = $this->Model->r0004Page($pageNum);

		require $this->getViewFile('reports/r0004');
	}

	/**
	 * Звіт по виконаним внутрішнім документам.
	 */
	public function r0005Page () {
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

		$d = $this->Model->r0005Page($pageNum);

		require $this->getViewFile('reports/r0005');
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

	/**
	 * Звіт по вхідним документам на контролі.
	 */
	public function r0006Page () {
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

		$d = $this->Model->r0006Page($pageNum);

		require $this->getViewFile('reports/r0006');
	}

	/**
	 * Звіт по внутрішнім документам на контролі.
	 */
	public function r0007Page () {
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

		$d = $this->Model->r0007Page($pageNum);

		require $this->getViewFile('reports/r0007');
	}

	/**
	 * Звіт по виконавцім, які не виконали документи.
	 */
	public function r0008Page () {
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

		$d = $this->Model->r0008Page($pageNum);

		require $this->getViewFile('reports/r0008');
	}

	/**
	 * Звіт по простроченим вхідним документам.
	 */
	public function r0009Page () {
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

		$d = $this->Model->r0009Page($pageNum);

		require $this->getViewFile('reports/r0009');
	}

	/**
	 * Звіт по простроченим вхідним документам.
	 */
	public function r0010Page () {
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

		$d = $this->Model->r0010Page($pageNum);

		require $this->getViewFile('reports/r0010');
	}
}
