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
			$this->allowedStatuses = ['User', 'Admin', 'SuperAdmin'];
		}

		return $this->allowedStatuses;
	}

	public function sourceSelectionPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$d['title'] = 'Оберіть джерело документа';

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

		$d['title'] = 'Додавання типу документа';
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

		$pageNum = isset($Post->post['pg']) ? $Post->post['pg'] : 1;

		$d = $this->Model->incomingPage($pageNum);

		require $this->getViewFile('document_registration/incoming');
	}

	public function outgoingPage () {
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

		if ($Post->errors) dd($Post, __FILE__, __LINE__,1);

		$pageNum = isset($Post->post['pg']) ? $Post->post['pg'] : 1;

		$d = $this->Model->outgoingPage($pageNum);

		require $this->getViewFile('document_registration/outgoing');
	}

	public function internalPage () {
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

		$pageNum = isset($Post->post['pg']) ? $Post->post['pg'] : 1;

		$d = $this->Model->internalPage($pageNum);

		require $this->getViewFile('document_registration/internal');
	}

	/**
	 * Додавання вхідного документа до БД.
	 */
	public function incomingAddPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Post = new Post('fm_addIncomingDocument', [
			'dIncomingDate' => [
				'type' => 'date',
				'isRequired' => false
			],
			'dType' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dCarrierType' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dLocation' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dTitle' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dDescription' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dStatus' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dSender' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dRecipientUser' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dOutgoingNumber' => [
				'type' => 'varchar',
				'pattern' => '^(OUT_\d{8})?$',
				'isRequired' => false
			],
			'dResponsibleUser' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dAssignedUser' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dAssignedDepartament' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dResolution' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dControlType' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dControlTerm' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dFile' => [
				'type' => 'text',
				'isRequired' => false
			],
			'bt_add' => [
				'type' => 'varchar',
				'pattern' => '^$',
				'isRequired' => true
			],
		]);

		if ($Post->errors) {
			sess_addErrMessage('Отримано некоректні дані форми');
			hd_sendHeader('Location: '. url('/df/document-registration/incoming'), __FILE__, __LINE__);
		}

		$DocNew = $this->Model->addIncomingDocument($Post);

		if ($DocNew) {
			sess_addSysMessage('Документ додано до реєстра');
			hd_sendHeader('Location: '. url('/df/documents-incoming/card?n='. $DocNew->_number),
				__FILE__, __LINE__);
		}
		else {
			sess_addErrMessage('Помилка! Документ не додано до реєстра');
		}

		hd_sendHeader('Location: '. url('/df/document-registration/incoming'), __FILE__, __LINE__);
	}

	/**
	 * Додавання вихідного документа до БД.
	 */
	public function outgoingAddPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$regexp = require DirConfig .'/regexp.php';

		$Post = new Post('fm_addIncomingDocument', [
			'dOutgoingDate' => [
				'type' => 'date',
				'isRequired' => false
			],
			'dType' => [
				'type' => 'int',
				'isRequired' => true
			],
			'registrationFormNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^([a-zA-Z0-9_-]{1,255})?$'
			],
			'dCarrierType' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dLocation' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dTitle' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dDescription' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dStatus' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dIncomingNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(INC_\d{8})?$',
			],
			'dSender' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dRecipientUser' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dResponsibleUser' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dAssignedUser' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dControlType' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dControlTerm' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dFile' => [
				'type' => 'text',
				'isRequired' => false
			],
			'bt_add' => [
				'type' => 'varchar',
				'pattern' => '^$',
				'isRequired' => true
			],
		]);

		if ($Post->errors) {
			sess_addErrMessage('Отримано некоректні дані форми');
			hd_sendHeader('Location: '. url('/df/document-registration/outgoing'), __FILE__, __LINE__);
		}

		$DocNew = $this->Model->addOutgoingDocument($Post);

		if ($DocNew) {
			sess_addSysMessage('Документ додано до реєстра');
		}
		else {
			sess_addErrMessage('Помилка! Документ не додано до реєстра');
		}

		hd_sendHeader('Location: '. url('/df/document-registration/outgoing'), __FILE__, __LINE__);
	}

	/**
	 * Додавання внутрішнього документа до БД.
	 */
	public function internalAddPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Post = new Post('fm_addIncomingDocument', [
			'dInternalDate' => [
				'type' => 'date',
				'isRequired' => false
			],
			'dAdditionalNumber' => [
				'type' => 'varchar',
				'pattern' => '^[a-zA-Z0-9_-]{1,10}$',
				'isRequired' => false
			],
			'dUserInitiator' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dType' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dCarrierType' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dLocation' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dTitle' => [
				'type' => 'int',
				'isRequired' => true
			],
			'dDescription' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dStatus' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dRecipientUser' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dOutgoingNumber' => [
				'type' => 'varchar',
				'pattern' => '^(OUT_\d{8})?$',
				'isRequired' => false
			],
			'dResponsibleUser' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dAssignedUser' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dAssignedDepartament' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dControlType' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dControlTerm' => [
				'type' => 'int',
				'isRequired' => false
			],
			'distributionScope' => [
				'type' => 'int',
				'isRequired' => false
			],
			'dFile' => [
				'type' => 'text',
				'isRequired' => false
			],
			'bt_add' => [
				'type' => 'varchar',
				'pattern' => '^$',
				'isRequired' => true
			],
		]);

		if ($Post->errors) {
			sess_addErrMessage('Отримано некоректні дані форми');
			hd_sendHeader('Location: '. url('/df/document-registration/incoming'), __FILE__, __LINE__);
		}

		$DocNew = $this->Model->addInternalDocument($Post);

		if ($DocNew) {
			sess_addSysMessage('Документ додано до реєстра');
		}
		else {
			sess_addErrMessage('Помилка! Документ не додано до реєстра');
		}

		hd_sendHeader('Location: '. url('/df/document-registration/internal'), __FILE__, __LINE__);
	}
}
