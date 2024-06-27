<?php

namespace modules\df\controllers;

use \core\Get;
use \core\Post;
use \modules\df\controllers\MainController as MC;
use \modules\df\models\DocumentsOutgoingModel;

/**
 * Контроллер вхідних документів.
 */
class DocumentsOutgoingController extends MC {

	private DocumentsOutgoingModel $Model;

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

	/**
	 *
	 */
	public function mainPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$d = $this->Model->mainPage();

		require $this->getViewFile('documents_outgoing/main');
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
			],
			'clear' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^y$'
			],
		]);

		if ($_POST) {
			$Post = new Post('doc_list', [
				'docsId' => [
					'type' => 'array',
					'isRequired' => false,
					'pattern' => '^\d{1,5}$',
				],
				'deleteDocuments' => [
					'type' => 'varchar',
					'isRequired' => true,
					'pattern' => '^$'
				],
			]);

			if (isset($_POST['deleteDocuments']) && ($Us->Status->_access_level < 3)) {
				if (isset($_POST['docsId'])) {
					$affectedRows = $this->Model->toTrashBinDocuments();

					if ($affectedRows > 0) {
						sess_addSysMessage('Документи переміщені в корзину');
					}
				}
			}

			hd_sendHeader('Location: '. url('/df/documents-outgoing/list'), __FILE__, __LINE__);
		}

		$pageNum = isset($_GET['pg']) ? $Get->get['pg'] : 1;

		$d = $this->Model->listPage($pageNum);

		if (! $d) hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);

		require $this->getViewFile('documents_outgoing/list');
	}

	/**
	 *
	 */
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

		require $this->getViewFile('documents_outgoing/card');
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

		$Post = new Post('out_card_action', [
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
			'dTitle' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,4}$'
			],
			'dIdDescription' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(OUT_\d{8})?$'
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
			'dRegistrar' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^[a-zA-Z0-9_]{5,32}$'
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
			'dIdSender' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIdRecipient' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dIncNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(INC_\d{8})?$'
			],
			'dRegistrationFormNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^([a-zA-Z0-9_-]{1,32})?$'
			],
			'dIdExecutorUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dExecutorUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^[a-zA-Z0-9_]{5,32}$'
			],
			'dIsReceivedExecutorUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '(^$|^\d{4}-\d{2}-\d{2}$)$'
			],
			'dDueDateBefore' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '(^$|^\d{4}-\d{2}-\d{2}$)$'
			],
			'dIdControlType' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,4})?$'
			],
			'dExecutionDate' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^('. $regexp['date'] .')?$'
			],
			'dExecutionDateDel' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(on)?$'
			],
			'dDueDateBeforeDel' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(on)?$'
			],
			'dDateDel' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(on)?$'
			],
			'bt_edit' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^$'
			],
		]);

		/** @var outgoing_documents_registry|false */
		$Doc = $this->Model->cardActionPage();

		if (isset($_FILES['dFile']) && $_FILES['dFile']['name']) {
			$replRes = $this->Model->replaceDocumentFile($Doc);

			if ($replRes) sess_addSysMessage('Файл документу замінено');
		}

		$num = $Doc ? $Doc->_number : $Get->get['n'];


		if ($Doc && ((time() - strtotime($Doc->_change_date)) < 1)) {
			sess_addSysMessage('Дані змінено.');
		}
		else if (! $Doc) {
			sess_addErrMessage('Помилка зміни даних.', false);
		}

		hd_sendHeader('Location: '. url('/df/documents-outgoing/card?n='. $num), __FILE__, __LINE__);
	}
}
