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

		$pageNum = isset($Post->post['pg']) ? $Post->post['pg'] : 1;

		$d = $this->Model->outgoingPage($pageNum);

		require $this->getViewFile('document_registration/outgoing');
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
				'pattern' => '^OUT_\d{5}$',
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

		$addResult = $this->Model->addIncomingDocument($Post);

		if ($addResult['lastInsertId']) {
			sess_addSysMessage('Документ додано до реєстра');
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

		$Post = new Post('fm_addIncomingDocument', [
			'dOutgoingDate' => [
				'type' => 'date',
				'isRequired' => false
			],
			'dType' => [
				'type' => 'int',
				'isRequired' => true
			],
			'registrationForm' => [
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
			'dIncomingNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^INC_\d{5}$',
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

		$addResult = $this->Model->addOutgoingDocument($Post);

		if ($addResult['lastInsertId']) {
			sess_addSysMessage('Документ додано до реєстра');
		}
		else {
			sess_addErrMessage('Помилка! Документ не додано до реєстра');
		}

		hd_sendHeader('Location: '. url('/df/document-registration/outgoing'), __FILE__, __LINE__);
	}
}
