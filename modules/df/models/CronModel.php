<?php

namespace modules\df\models;

use core\db_record\incoming_documents_registry;
use core\db_record\users;
use \core\User;
use \modules\df\models\MainModel;

/**
 * Модель пошуку документів.
 */
class CronModel extends MainModel {

	/**
	 * @return array
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * Повідомлення користувачів про непрочитані повідомлення.
	 */
	public function notifyAboutUnreadMessages () {
		$users = db_users_getTelegramData(5);

		foreach ($users as $rowUser) {
			$UsTemp = new User($rowUser['us_id']);

			if ($UsTemp->_id_tg && ($countMsgs = $UsTemp->getUnreadMessagesCount())) {
				tg_sendMsg(
					$UsTemp->_id_tg, "❇️ Ви маєте ". $countMsgs ." непрочитаних [повідомлень](".
						url('/messages') .")"
				);
			}
		}
	}

	/**
	 * Повідомлення користувачів про дати контроля.
	 */
	public function notifyAboutControlDate () {
		$SQL = db_getSelect()
			->columns(['idr_id', 'us_id'])
			->from(DbPrefix .'incoming_documents_registry')
			->join(DbPrefix .'users', 'us_id', '=', 'idr_id_assigned_user')
			->where('idr_execution_date', '=', null)
			->where('idr_date_of_receipt_by_executor', '!=', null)
			->where('idr_id_execution_control', '!=', null);

		$documents = db_select($SQL);

		foreach ($documents as $rowData) {
			$Doc = new incoming_documents_registry($rowData['idr_id']);
			$controlDate = $Doc->NextControlDate->format('Y-m-d');

			if ($controlDate === tm_getDatetime()->format('Y-m-d')) {
				$UsTemp = new users($rowData['us_id']);

				// if ($UsTemp->_id_tg) {
				// 	tg_sendMsg(
				// 		$UsTemp->_id_tg,
				// 		"❇ Сьогодні контрольна дата документа [". $Doc->displayedNumber ."](". $Doc->cardURL .")."
				// 	);
				// }


				$msg = 'Сьогодні контрольна дата документа <a href="'. $Doc->cardURL .'">'.
					$Doc->displayedNumber .'</a>';

				msg_add($UsTemp->_id, 1, $msg, 'Контрольна дата документа', 'Warning');
			}
		}
	}
}
