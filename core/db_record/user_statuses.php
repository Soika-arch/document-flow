<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці user_statuses.
 */
class user_statuses extends DbRecord {

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		parent::__construct($id, $dbRow);
	}
}
