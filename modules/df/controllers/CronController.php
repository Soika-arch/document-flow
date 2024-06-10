<?php

namespace modules\df\controllers;

use \core\db_record\cron_tasks;
use \libs\cron\CronExpression;
use \modules\df\controllers\MainController as MC;
use \modules\df\models\CronModel;

/**
 * Контроллер пошуку документів.
 */
class CronController extends MC {

	private CronModel $Model;

	public function __construct () {
		require_once DirModules .'/df/functions/df.php';
		$this->Model = new CronModel();
	}

	/**
	 * Ініціалізує та повертає властивість $this->allowedStatuses.
	 */
	private function get_allowedStatuses () {
		if (! isset($this->allowedStatuses)) {
			$this->allowedStatuses = ['Guest', 'Viewer', 'User', 'Admin', 'SuperAdmin'];
		}

		return $this->allowedStatuses;
	}

	/**
	 *
	 */
	public function mainPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		require_once DirFunc .'/cron.php';

		$cronTasks = cron_getTasks();

		foreach ($cronTasks as $task) {
			$Cron = CronExpression::factory($task['crt_schedule']);
			$LastRunDate = new \DateTime($task['crt_last_run']);
			$CurrentDate = new \DateTime();

			if (! $task['crt_last_run'] || ($Cron->getNextRunDate($LastRunDate) <= $CurrentDate)) {
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

	public function t0001 () {
		$this->Model->notifyAboutControlDate();
	}

	public function t0002 () {
		$this->Model->notifyAboutUnreadMessages();
	}

	public function t0003 () {
		$this->Model->backupOfDatabaseTables();
	}

	public function t0003Page () {
		$this->Model->backupOfDatabaseTables();
	}
}
