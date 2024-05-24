<?php

namespace modules\df\models;

use \core\Get;
use core\Post;
use \modules\df\models\MainModel;

/**
 * Модель пошуку документів.
 */
class SearchModel extends MainModel {

	/**
	 * @return array
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * @return array
	 */
	public function mainPage () {
		$Get = new Get([
			'uri' => [
				'type' => 'varchar',
				'isRequired' => false,
				'pattern' => '^[a-z0-9_-]{2,32}$'
			]
		]);

		$d['title'] = 'Пошук документів';
		$d['targetURL'] = str_replace('_', '/', trim($Get->get['uri'], '/'));
		$d['departaments'] = $this->selectRowsByCol(DbPrefix .'departments');

		$users = $this->selectRowsByCol(DbPrefix .'users', 'us_id', '0', [], '>');

		if ($Get->get['uri'] === 'df_documents-outgoing_list') {
			$d['sendersUsers'] = $users;
			$d['recipientsExternal'] = $this->selectRowsByCol(DbPrefix .'document_senders');
		}
		else if (($Get->get['uri'] === 'df_documents-incoming_list') || ($Get->get['uri'] === 'df')) {
			$d['sendersExternal'] = $this->selectRowsByCol(DbPrefix .'document_senders');
			$d['recipientsUsers'] = $users;
		}
		else if ($Get->get['uri'] === 'df_documents-internal_list') {
			$d['sendersUsers'] = $users;
			$d['recipientsUsers'] = $users;
		}

		return $d;
	}

	/**
	 * @return array
	 */
	public function handlerPage (Post $Post) {
		$post = $Post->post;
		$params = [];

		if (isset($post['dAge'])) $params['d_age'] = $post['dAge'];

		$d['targetURL'] = url('/'. $post['targetURL'], $params);

		return $d;
	}
}
