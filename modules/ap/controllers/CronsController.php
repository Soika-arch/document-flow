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
}
