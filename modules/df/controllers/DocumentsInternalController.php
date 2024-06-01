<?php

namespace modules\df\controllers;

use \core\Get;
use \core\Post;
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
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'del_doc' => [
				'type' => 'varchar',
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

		$pageNum = isset($_GET['pg']) ? $Get->get['pg'] : 1;

		$d = $this->Model->listPage($pageNum);

		if (! $d) hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);

		require $this->getViewFile('documents_internal/list');
	}

	public function cardPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'n' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^\d{8}$'
			]
		]);

		$d = $this->Model->cardPage($Get);

		require $this->getViewFile('documents_internal/card');
	}

	public function cardActionPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'n' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^\d{8}$'
			]
		]);

		if ($Get->errors) hd_sendHeader('Location: '. url('/not-found'), __FILE__, __LINE__);

		$regexp = require DirConfig .'/regexp.php';

		$Post = new Post('int_card_action', [
			'dIdDocumentType' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIdTitle' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIdDescription' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(INT_\d{8})?$'
			],
			'dAdditionalNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^([a-zA-Z0-9_-]{1,255})?$'
			],
			'dIdCarrierType' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIdRegistrar' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dDate' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^('. $regexp['date'] .')?$'
			],
			'dRegistrationDate' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^('. $regexp['date'] .')?$'
			],
			'dIdDocumentLocation' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIdInitiator' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIdRecipient' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIdExecutorUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIsReceivedExecutorUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^('. $regexp['date'] .')?$'
			],
			'dDueDateBefore' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^('. $regexp['date'] .')?$'
			],
			'dExecutionDate' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^('. $regexp['date'] .')?$'
			],
			'dIdResponsibleUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIdControlType' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIdRresolution' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dResolutionDate' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^('. $regexp['date'] .')?$'
			],
			'bt_edit' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^$'
			],
		]);

		/** @var incoming_documents_registry|false */
		$Doc = $this->Model->cardActionPage();

		$num = $Doc ? $Doc->_number : $Get->get['n'];


		if ($Doc && ((time() - strtotime($Doc->_change_date)) < 1)) {
			sess_addSysMessage('Дані змінено.');
		}
		else if (! $Doc) {
			sess_addErrMessage('Помилка зміни даних.');
		}

		hd_sendHeader('Location: '. url('/df/documents-internal/card?n='. $num), __FILE__, __LINE__);
	}
}
