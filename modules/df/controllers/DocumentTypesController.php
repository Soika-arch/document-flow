<?php

namespace modules\df\controllers;

use \core\Get;
use \core\controllers\MainController;
use \modules\df\models\DocumentTypesModel;

/**
 * Контроллер типів документів.
 */
class DocumentTypesController extends MainController {

	private DocumentTypesModel $Model;

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

		$d['title'] = 'ЕД - Типи документів';

		require $this->getViewFile('document_types/main');
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

	public function listPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
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

		if ($Get->errors) dd($Get->errors, __FILE__, __LINE__,1);

		// Видалення типу документа.
		if (isset($_GET['del_type'])) {
			// $UsDeleted = new User($_GET['del_type']);
			$login = $UsDeleted->_login;
			$resDel = $UsDeleted->delete();

			if ($resDel['rowCount']) {
				sess_addSysMessage('Користувача <b>'. $login .'</b> видалено.');
				hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);
			}
		}

		$d['title'] = 'ЕД - Типи документів';

		$pageNum = isset($Get->get['pg']) ? $Get->get['pg'] : 1;

		$d['DTData'] = $this->Model->listPage($pageNum);

		require $this->getViewFile('document_types/list');
	}
}
