<?php

namespace modules\df\models;

use \core\User;
use \core\db_record\cron_tasks;
use \core\db_record\users;
use \libs\cron\CronExpression;
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

		require_once DirFunc .'/cron.php';

		$cronTasks = cron_getTasks();

		foreach ($cronTasks as $task) {
			$Cron = CronExpression::factory($task['crt_schedule']);
			$LastRunDate = new \DateTime($task['crt_last_run']);
			$CurrentDate = new \DateTime();

			if ($Cron->getNextRunDate($LastRunDate) <= $CurrentDate) {
				// Час виконання крон задачі.

				$method = $task['crt_task_name'];
				// Виконання відповідної cron задачі.
				$this->$method();

				$CronRow = new cron_tasks($task['crt_id'], $task);

				// Оновлення часу останнього і часу наступного виконання cron задачі.
				$CronRow->update([
					'crt_last_run' => $CurrentDate->format('Y-m-d H:i:s'),
					'crt_next_run' => $Cron->getNextRunDate()->format('Y-m-d H:i:s')
				]);
			}
		}
	}

	/**
	 * Повідомлення користувачів про непрочитані повідомлення.
	 */
	public function notifyAboutUnreadMessages () {
		$users = users_getTelegramData(5);

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
		$documents = doc_receiveDocumentsAtControl('incoming_documents_registry', ['idr_id', 'us_id']);
		$this->sendMessagesAboutControlDate('incoming_documents_registry', $documents);
		$documents = doc_receiveDocumentsAtControl('internal_documents_registry', ['inr_id', 'us_id']);
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
					tg_sendMsg(
						$UsTemp->_id_tg,
						"❇ Сьогодні контрольна дата документа [". $Doc->displayedNumber ."](". $Doc->cardURL .")."
					);
				}

				$msg = 'Сьогодні контрольна дата документа <a href="'. $Doc->cardURL .'">'.
					$Doc->displayedNumber .'</a>';

				msg_add($UsTemp->_id, 1, $msg, 'Контрольна дата документа', 'Warning');
			}
		}
	}
}
