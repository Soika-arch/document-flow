<?php

namespace modules\df\controllers;

use \core\Get;
use \core\Post;
use \modules\df\controllers\MainController as MC;
use \modules\df\models\DocumentsIncomingModel;

/**
 * Контроллер вхідних документів.
 */
class DocumentsIncomingController extends MC {

	private DocumentsIncomingModel $Model;

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

		require $this->getViewFile('documents_incoming/main');
	}

	public function listPage () {
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

		$d = $this->Model->listPage($pageNum);

		if (! $d) hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);

		require $this->getViewFile('documents_incoming/list');
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

		$d = $this->Model->cardPage();

		require $this->getViewFile('documents_incoming/card');
	}

	public function cardActionPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Get = new Get([
			'n' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^\d{4}$'
			]
		]);

		$Post = new Post('inc_card_action', [
			'dTitle' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'dNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^INC_[A-Z0-9]{6}$'
			],
			'dRegistrar' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'dIncNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^OUT_[A-Z0-9]{6}$'
			],
			'dExecutorUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'dIsReceivedExecutorUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '(^$|^\d{4}-\d{2}-\d{2}$)$'
			],
			'bt_edit' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^$'
			],
		]);

		/** @var incoming_documents_registry|false */
		$Doc = $this->Model->cardActionPage();
		$num = $Get->get['n'];

		if ($Doc) {
			sess_addSysMessage('Дані змінено.');
			hd_sendHeader('Location: '. url('/df/documents-incoming/card?n='. $num), __FILE__, __LINE__);
		}

		sess_addErrMessage('Помилка зміни даних.');
		hd_sendHeader('Location: '. url('/df/documents-incoming/card?n='. $num), __FILE__, __LINE__);
	}
}
