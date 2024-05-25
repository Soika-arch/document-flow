<?php

namespace modules\df\models;

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
		$get = rg_Rg()->get('Get')->get;

		$d['title'] = 'Пошук документів';
		$d['targetURL'] = $get['uri'];
		$d['departaments'] = $this->selectRowsByCol(DbPrefix .'departments');

		$users = $this->selectRowsByCol(DbPrefix .'users', 'us_id', '0', [], '>');

		if ($get['uri'] === 'df_documents-outgoing_list') {
			$d['sendersUsers'] = $users;
			$d['recipientsExternal'] = $this->selectRowsByCol(DbPrefix .'document_senders');
		}
		else if (($get['uri'] === 'df_documents-incoming_list') || ($get['uri'] === 'df')) {
			$d['sendersExternal'] = $this->selectRowsByCol(DbPrefix .'document_senders');
			$d['recipientsUsers'] = $users;
		}
		else if ($get['uri'] === 'df_documents-internal_list') {
			$d['sendersUsers'] = $users;
			$d['recipientsUsers'] = $users;
		}

		return $d;
	}

	/**
	 * @return array
	 */
	public function handlerPage () {
		$post = rg_Rg()->get('Post')->post;

		if (isset($post['pg'])) unset($post['pg']);

		$params = [];

		if (isset($post['dAge']) && $post['dAge']) $params['d_age'] = $post['dAge'];

		if (isset($post['dMonth']) && $post['dAge']) $params['d_month'] = $post['dMonth'];

		if (isset($post['dDay']) && $post['dDay']) $params['d_day'] = $post['dDay'];

		if (isset($post['dLocation']) && $post['dLocation']) $params['d_location'] = $post['dLocation'];

		if (isset($post['dSenderExternal']) && $post['dSenderExternal']) {
			$params['d_sender_external'] = $post['dSenderExternal'];
		}

		if (isset($post['dRecipientUser']) && $post['dRecipientUser']) {
			$params['d_recipient_user'] = $post['dRecipientUser'];
		}

		if (isset($post['dSenderUser']) && $post['dSenderUser']) {
			$params['d_sender_user'] = $post['dSenderUser'];
		}

		sess_addGetParameters($params);

		$d['targetURL'] = url('/'. str_replace('_', '/', $post['targetURL']));

		return $d;
	}
}
