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
			'clear' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^y$'
			]
		]);

		$get = $Get->get;

		if (isset($Get->get['clear']) && ($Get->get['clear'] === 'y')) {
			sess_delGetParameters();
			unset($get['clear']);
			hd_sendHeader('Location: '. url('', $get), __FILE__, __LINE__);
		}

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
			'documentDirection' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^.*$'
			],
			'dNumber' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^([a-zA-Z0-9_]{1,12})?$'
			],
			'dAge' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '(^\d{4}$|^$)'
			],
			'dMonth' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,2})?$'
			],
			'dDay' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,2})?$'
			],
			'dDateFrom' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^('. $patterns['date'] .')?$'
			],
			'dDateUntil' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^('. $patterns['date'] .')?$'
			],
			'dSenderExternal' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,5})?$'
			],
			'dSenderUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,5})?$'
			],
			'dRecipientExternal' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,5})?$'
			],
			'dRecipientUser' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,5})?$'
			],
			'dRegistrar' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,5})?$'
			],
			'dLocation' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^(\d{1,5})?$'
			],
			'bt_search' => [
				'type' => 'varchar',
				'isRequired' => true,
				'pattern' => '^$'
			],
		]);
		if ($Post->errors) dd($Post, __FILE__, __LINE__,1);
		$post = $Post->post;

		if ((isset($post['dDateFrom']) && $post['dDateFrom'])) {
			if ((isset($post['dDateUntil']) && $post['dDateUntil'])) {
				if (strtotime($post['dDateUntil']) < strtotime($post['dDateFrom'])) {
					sess_addErrMessage('Період дати документу: дата "Від" повинна бути менше дати "До"');
					hd_sendHeader('Location: '. url('/df/search'), __FILE__, __LINE__);
				}
			}
		}

		$d = $this->Model->handlerPage();

		hd_sendHeader('Location: '. $d['targetURL'], __FILE__, __LINE__);
	}
}
