<?php

namespace core\controllers\cron;

use core\controllers\MainController;

/**
 * Контроллер cron-задач.
 */
class CronController extends MainController {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *
	 */
	public function mainPage () {
		dd('Автоматична очистка таблиць БД', __FILE__, __LINE__,1);
	}
}
