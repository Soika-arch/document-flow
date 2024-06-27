<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці card_comments.
 */
class card_comments extends DbRecord {

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		parent::__construct($id, $dbRow);
	}
}
