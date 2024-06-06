<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці cron_tasks.
 */
class cron_tasks extends DbRecord {

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		parent::__construct($id, $dbRow);
	}
}
