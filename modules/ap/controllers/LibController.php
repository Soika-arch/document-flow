<?php

namespace modules\ap\controllers;

use \core\Post;
use \modules\ap\controllers\MainController;
use \modules\ap\models\LibModel;

/**
 * Контроллер адмін-панелі управління безпекою сайта.
 */
class LibController extends MainController {

	private LibModel $Model;

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

		require $this->getViewFile('lib/main');
	}

	public function documentTitlesAddPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		if (isset($_POST['bt_docTitle'])) {
			$regexp = require DirConfig .'/regexp.php';

			$Post = new Post('fm_docTitle', [
				'docTitle' => [
					'type' => 'varchar',
					'pattern' => '^'. $regexp['freeTextClass'] .'{3,255}$',
					'isRequired' => true,
				],
				'bt_docTitle' => [
					'type' => 'varchar',
					'pattern' => '^$',
					'isRequired' => true,
				]
			]);

			if (! $Post->errors) {
				$NewDocTitle = $this->Model->documentTitleAdd();

				if ($NewDocTitle) {
					sess_addSysMessage('Нова назва (заголовок) документа <b>"'. $NewDocTitle->_title .
						'" створена</b>');

					hd_sendHeader('Location: '. url('/ap/lib/document-titles-add'), __FILE__, __LINE__);
				}
			}
		}

		$d = $this->Model->documentTitlesAddPage();

		require $this->getViewFile('lib/document_titles_add');
	}

	public function documentDescriptionsAddPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		if (isset($_POST['bt_docDescription'])) {
			$regexp = require DirConfig .'/regexp.php';

			$Post = new Post('fm_docDescription', [
				'docDescription' => [
					'type' => 'text',
					'pattern' => '^'. $regexp['freeTextClass'] .'{3,600}$',
					'isRequired' => true,
				],
				'bt_docDescription' => [
					'type' => 'varchar',
					'pattern' => '^$',
					'isRequired' => true,
				]
			]);

			if (! $Post->errors) {
				$DocDescription = $this->Model->documentDescriptionAdd();

				if ($DocDescription) {
					sess_addSysMessage('Новий опис документа <b>"'. $DocDescription->_description .
						'" створено</b>');

					hd_sendHeader('Location: '. url('/ap/lib/document-descriptions-add'), __FILE__, __LINE__);
				}
			}
		}

		$d = $this->Model->documentDescriptionsAddPage();

		require $this->getViewFile('lib/document_descriptions_add');
	}
}
