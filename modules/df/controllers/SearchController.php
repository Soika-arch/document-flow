<?php

namespace modules\df\controllers;

use \core\Get;
use \core\Post;
use \modules\df\controllers\MainController as MC;
use \modules\df\models\SearchModel;

/**
 * Контроллер пошуку документів.
 */
class SearchController extends MC {

	private SearchModel $Model;

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

		$Get = new Get([
			'uri' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^[a-z0-9_-]{2,32}$'
			]
		]);

		$d = $this->Model->mainPage();

		require $this->getViewFile('search/main');
	}

	/**
	 * @return
	 */
	public function handlerPage () {
		$Us = rg_Rg()->get('Us');
		$patterns = require DirConfig .'/regexp.php';

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$Post = new Post('search_1', [
			'targetURL' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => $patterns['standartURI']
			],
			'dAge' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '(^\d{4}$|^$)'
			],
			'dMonth' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,2}$'
			],
			'dDay' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,2}$'
			],
			'dSenderExternal' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,5}$'
			],
			'dSenderUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,5}$'
			],
			'dRecipientExternal' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,5}$'
			],
			'dRecipientUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,5}$'
			],
			'dLocation' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^\d{1,5}$'
			],
			'bt_search' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^$'
			],
		]);

		if ($Post->errors) dd($Post, __FILE__, __LINE__,1);

		$d = $this->Model->handlerPage();

		hd_sendHeader('Location: '. $d['targetURL'], __FILE__, __LINE__);
	}
}
