<?php

namespace modules\df\controllers;

use \core\Post;
use \modules\df\controllers\MainController as MC;
use \modules\df\models\DocumentRegistrationModel;

/**
 * Контроллер реєстрації документів.
 */
class DocumentRegistrationController extends MC {

	private DocumentRegistrationModel $Model;

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

	public function sourceSelectionPage () {
		$Us = rg_Rg()->get('Us');
		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$d['title'] = 'ЕД - Оберіть джерело документа';

		require $this->getViewFile('document_registration/type_selection');
	}

	public function addPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		if (isset($_POST['bt_addDt'])) {
			if ($this->Model->addDocumentType()) {
				hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);
			}
		}

		$d['title'] = 'ЕД - Додавання типу документа';
		$d = array_merge($d, $this->Model->add());

		require $this->getViewFile('document_types/add');
	}

	public function incomingPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Post = new Post('fm_addIncomingDocument', [
			'pg' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'del_type' => [
				'type' => 'int',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			]
		]);

		$d['title'] = 'ЕД - Реєстрація вхідного документа';

		$d['users'] = $this->Model->selectRowsByCol(DbPrefix .'users', 'us_id', '0', [], '>');

		$pageNum = isset($Post->post['pg']) ? $Post->post['pg'] : 1;

		$d['incomingData'] = $this->Model->incomingPage($pageNum);

		require $this->getViewFile('document_registration/incoming');
	}

	/**
	 * Реєстрація вхідного документа.
	 * @return
	 */
	protected function incomingRegisterPage () {
		dd(__METHOD__, __FILE__, __LINE__,1);
	}
}
