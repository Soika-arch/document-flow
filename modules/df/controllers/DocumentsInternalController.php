<?php

namespace modules\df\controllers;

use \core\Get;
use \modules\df\controllers\MainController as MC;
use \modules\df\models\DocumentsInternalModel;

/**
 * Контроллер внутрішніх документів.
 */
class DocumentsInternalController extends MC {

	private DocumentsInternalModel $Model;

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

		require $this->getViewFile('documents_internal/main');
	}

	public function listPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'pg' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'del_doc' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			]
		]);

		if ($Get->errors) dd($Get->errors, __FILE__, __LINE__,1);

		$pageNum = isset($_GET['pg']) ? $Get->get['pg'] : 1;

		$d = $this->Model->listPage($pageNum);

		require $this->getViewFile('documents_internal/list');
	}

	public function cardPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'n' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^\d{4}$'
			]
		]);

		$d = $this->Model->cardPage($Get);

		require $this->getViewFile('documents_internal/card');
	}
}
