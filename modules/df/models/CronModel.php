<?php

namespace modules\df\models;

use \core\User;
use \core\db_record\users;
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
	 *
	 */
	public function mainPage () {


	}

	/**
	 * Повідомлення користувачів про непрочитані повідомлення.
	 */
	public function notifyAboutUnreadMessages () {
		$users = users_getTelegramData(5);

		foreach ($users as $rowUser) {
			$UsTemp = new User($rowUser['us_id']);

			if ($countMsgs = $UsTemp->getUnreadMessagesCount()) {
				if ($UsTemp->_id_tg) {
					$msg = "❇️ Ви маєте ". $countMsgs ." непрочитаних [повідомлень](". url('/messages') .")";
					tg_sendMsg($UsTemp->_id_tg, $msg);
				}

				if ($UsTemp->_email) {
					$msg = '<html><head><title>Document-flow: непрочитані повідомлення</title></head>'.
						'<body><p>Ви маєте '. $countMsgs .' непрочитаних <a href="'. url('/messages') .
						'">повідомлень</a>.</p></body></html>';

					$headers =
						"MIME-Version: 1.0\r\n".
						"From: \"DF-Admin\" <admin@petamicr.zzz.com.ua>\r\n".
						"Reply-To: vladimirovichser@gmail.com\r\n".
						"Content-type: text/html; charset=UTF-8\r\n";

					mail($UsTemp->_email, 'Document-flow: непрочитані повідомлення', $msg, $headers);
				}
			}
		}
	}

	/**
	 * Повідомлення користувачів про дати контроля.
	 */
	public function notifyAboutControlDate () {
		$documents = df_receiveDocumentsAtControl('incoming_documents_registry', ['idr_id', 'us_id']);
		$this->sendMessagesAboutControlDate('incoming_documents_registry', $documents);
		$documents = df_receiveDocumentsAtControl('internal_documents_registry', ['inr_id', 'us_id']);
		$this->sendMessagesAboutControlDate('internal_documents_registry', $documents);
	}

	/**
	 * Відправлення повідомлень користувачам про дати контроля.
	 */
	protected function sendMessagesAboutControlDate (string $documentType, array $documents) {
		$px = db_Db()->getColPxByTableName(DbPrefix . $documentType);
		$documentType = DirCore .'/db_record/'. $documentType;
		$documentType = trim(str_replace([DirRoot, '/'], '\\', $documentType), '\\');

		foreach ($documents as $rowData) {
			$Doc = new $documentType($rowData[$px .'id']);
			$controlDate = $Doc->NextControlDate->format('Y-m-d');

			if ($controlDate === tm_getDatetime()->format('Y-m-d')) {
				$UsTemp = new users($rowData['us_id']);

				if ($UsTemp->_id_tg) {
					$msg = "❇ Сьогодні контрольна дата документа [". $Doc->displayedNumber ."](".
						$Doc->cardURL .").";

					tg_sendMsg($UsTemp->_id_tg, $msg);
				}

				if ($UsTemp->_email) {
					$msg = '<html><head><title>Document-flow: контрольна дата документа</title></head>'.
						'<body><p>Сьогодні контрольна дата документа <a href="'. $Doc->cardURL .'">'.
						$Doc->displayedNumber .'</a>.</p></body></html>';

					$headers =
						"MIME-Version: 1.0\r\n".
						"From: \"DF-Admin\" <admin@petamicr.zzz.com.ua>\r\n".
						"Reply-To: vladimirovichser@gmail.com\r\n".
						"Content-type: text/html; charset=UTF-8\r\n";

					mail($UsTemp->_email, 'Document-flow: контрольна дата документа', $msg, $headers);
				}

				$msg = 'Сьогодні контрольна дата документа <a href="'. $Doc->cardURL .'">'.
					$Doc->displayedNumber .'</a>';

				msg_add($UsTemp->_id, 1, $msg, 'Контрольна дата документа', 'Warning');
			}
		}
	}
}
