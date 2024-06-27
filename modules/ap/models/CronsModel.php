<?php

namespace modules\ap\models;

use \core\db_record\cron_tasks;
use \core\RecordSliceRetriever;
use \libs\Paginator;
use \modules\df\models\MainModel;

/**
 * Модель управління cron задачами.
 */
class CronsModel extends MainModel {

	/**
	 *
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * @return array
	 */
	public function mainPage () {
		$d['title'] = 'Crons';

		return $d;
	}

	/**
	 * @return array
	 */
	public function listPage (int $pageNum=1) {
		$d['title'] = 'Crons - список';
		$tName = DbPrefix .'cron_tasks';

		$QB = db_DTSelect($tName .'.*')
			->from($tName);

		$QBSlice = new RecordSliceRetriever($QB);
		$itemsPerPage = 5;
		$d['crons'] = $QBSlice->select($itemsPerPage, $pageNum);
		$url = url('/ap/crons/list?pg=(:num)#pagin');
		$Pagin = new Paginator($QBSlice->getRowsCount(), $itemsPerPage, $pageNum, $url);
		$d['Pagin'] = $Pagin;

		return $d;
	}

	/**
	 *
	 */
	public function addPage () {
		$d['title'] = 'Cron - додавання нового завдання';

		return $d;
	}

	/**
	 * Обробка спроби додавання нового cron завдання в БД.
	 * @return \core\db_record\cron_tasks|false
	 */
	public function addCron () {
		$Post = rg_Rg()->get('Post');

		$existingId = $this->selectCellByCol(
			DbPrefix .'cron_tasks', 'crt_task_name', $Post->post['cMethodName'], 'crt_id'
		);

		if ($existingId) {
			$userLink = '<a href="'. url('/ap/crons/edit?id='. $existingId) .'" target="_blank">існує</a>';

			sess_addErrMessage('Cron завдання з назвою метода <b>'. $Post->post['cMethodName'] .
				'</b> вже '. $userLink);

			return false;
		}

		$dt = date('Y-m-d H:i:s');

		$CronNew = (new cron_tasks(null))->set([
			'crt_task_name' => $Post->post['cMethodName'],
			'crt_description' => $Post->post['cDescription'],
			'crt_schedule' => $Post->post['cSchedule'],
			'crt_is_active' => $Post->post['isActive'],
			'crt_last_run' => null,
			'crt_next_run' => null,
			'crt_parameters' => $Post->post['cParameters'] ? $Post->post['cParameters'] : null,
			'crt_add_date' => $dt,
			'crt_change_date' => $dt
		]);

		if ($CronNew->_id) {
			$cronLink = '<a href="'. url('/ap/crons/add') .'">'. $CronNew->_task_name .'</a>';
			sess_addSysMessage('Створено cron завдання <b>'. $cronLink .'</b>.');
		}

		return $CronNew;
	}
}
