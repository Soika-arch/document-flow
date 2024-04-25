<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці visitor_routes.
 */
class visitor_routes extends DbRecord {

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		parent::__construct($id, $dbRow);
	}
}
