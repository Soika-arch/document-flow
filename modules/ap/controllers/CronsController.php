<?php

namespace modules\ap\controllers;

use \core\controllers\CronController;
use \core\Get;
use \core\Post;
use \modules\ap\controllers\MainController;
use \modules\ap\models\CronsModel;

/**
 * Контроллер адмін-панелі управління cron задачами.
 */
class CronsController extends MainController {

	private CronsModel $Model;

	public function __construct () {
		$this->Model = $this->get_Model();
	}

	/**
	 * Ініціалізує та повертає властивість $this->allowedStatuses.
	 */
	private function get_allowedStatuses () {
		if (! isset($this->allowedStatuses)) {
			$this->allowedStatuses = ['Admin', 'SuperAdmin'];
		}

		return $this->allowedStatuses;
	}

	public function mainPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		$d = $this->Model->mainPage();

		require $this->getViewFile('cron/main');
	}

	public function listPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		if ($_GET) {
			$Get = new Get([
				'm' => [
					'type' => 'varchar',
					'isRequired' => false,
					'pattern' => '^t\d{4}$'
				],
				'confirm' => [
					'type' => 'varchar',
					'isRequired' => false,
					'pattern' => '^(y|n)$'
				]
			]);

			if (isset($Get->get['m'])) {
				$taskMethod = $Get->get['m'];
				$CronContr = (new CronController())->findControllerByMethod($taskMethod);

				if (isset($Get->get['confirm']) && ($Get->get['confirm'] === 'y')) {
					if ($CronContr->runTask($taskMethod)) {
						sess_addSysMessage('Cron задачу <b>'. get_class($CronContr) .'::'. $taskMethod .'()'.
							'</b> виконано.');

						hd_sendHeader('Location: '. url('/ap/crons/list'), __FILE__, __LINE__);
					}
				}

				$cronName = get_class($CronContr) .'::'. $taskMethod .'()';

				sess_addConfirmData([
					'question' => 'Виконати cron задачу [ <b>'. $cronName .'</b> ] ?',
					'sourceURL' => URL,
					'paramsForDeletion' => ['m']
				]);

				hd_sendHeader('Location: '. url('/confirmation'), __FILE__, __LINE__);
			}
		}

		$d = $this->Model->listPage();

		require $this->getViewFile('cron/list');
	}

	/**
	 * Сторінка створення cron завдання.
	 * @return
	 */
	public function addPage () {
		$Us = rg_Rg()->get('Us');

		if (! $this->checkPageAccess($Us->Status->_name, $this->get_allowedStatuses())) return;

		if (isset($_POST['bt_addCron'])) {
			$Post = new Post('fm_userAdd', [
				'cMethodName' => [
					'type' => 'varchar',
					'pattern' => '^t\d{4}$',
					'isRequired' => true,
				],
				'cDescription' => [
					'type' => 'varchar',
					'pattern' => '.*',
					'isRequired' => true,
				],
				'cSchedule' => [
					'type' => 'varchar',
					'pattern' => '^(\*|([0-5]?\d)) (\*|([01]?\d|2[0-3])) (\*|([01]?\d|2[0-9]|3[01]))'.
						' (\*|(0?[1-9]|1[0-2])) (\*|([0-7]))$',
					'isRequired' => true,
				],
				'isActive' => [
					'type' => 'varchar',
					'pattern' => '^(y|n)$',
					'isRequired' => true,
				],
				'cParameters' => [
					'type' => 'varchar',
					'pattern' => '.*',
					'isRequired' => true,
				],
				'bt_addCron' => [
					'type' => 'varchar',
					'pattern' => '^$'
				]
			]);

			if ($this->Model->addCron()) {
				hd_sendHeader('Location: '. url(''), __FILE__, __LINE__);
			}
		}

		$d = $this->Model->addPage();

		require $this->getViewFile('cron/add');
	}
}
