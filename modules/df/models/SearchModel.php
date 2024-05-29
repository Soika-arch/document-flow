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
		$d['title'] = 'Пошук документів';
		$d['departments'] = $this->selectRowsByCol(DbPrefix .'departments');
		$d['users'] = $this->getDocumentFlowParticipants();
		$d['documentSenders'] = $this->selectRowsByCol(DbPrefix .'document_senders');

		return $d;
	}

	/**
	 * @return array
	 */
	public function handlerPage () {
		$post = rg_Rg()->get('Post')->post;

		if (isset($post['pg'])) unset($post['pg']);

		$params = [];
		$dNumber = $post['dNumber'];

		if (isset($post['dNumber']) && $post['dNumber']) {
			if (($pos = strpos($post['dNumber'], '_')) !== false) $dNumber = substr($dNumber, ($pos + 1));

			if (! is_numeric($dNumber)) {
				sess_addErrMessage('У полі номера документа мають бути тильки числа');
				hd_sendHeader('Location: '. url('/df/search'), __FILE__, __LINE__);
			}

			$params['d_number'] = $dNumber;
		}

		if (isset($post['dAge']) && $post['dAge']) $params['d_age'] = $post['dAge'];

		if (isset($post['dMonth']) && $post['dMonth']) $params['d_month'] = $post['dMonth'];

		if (isset($post['dDay']) && $post['dDay']) $params['d_day'] = $post['dDay'];

		if (isset($post['dDateFrom']) && $post['dDateFrom']) $params['d_date_from'] = $post['dDateFrom'];

		if (isset($post['dDateUntil']) && $post['dDateUntil']) {
			$params['d_date_until'] = $post['dDateUntil'];
		}

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

		if (isset($post['dRegistrar']) && $post['dRegistrar']) {
			$params['d_registrar_user'] = $post['dRegistrar'];
		}

		sess_addGetParameters($params);

		if ($post['documentDirection'] === '') {
			$d['targetURL'] = url('/df');
		}
		else {
			$d['targetURL'] = $post['documentDirection'];
		}

		return $d;
	}
}
