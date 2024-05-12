<?php

namespace core\db_record;

/**
 * Модель для роботи з записом таблиці users.
 */
class users extends DbRecord {

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		parent::__construct($id, $dbRow);
	}

	/**
	 * @return array
	 */
	protected function get_relations () {
		if (! isset($this->relations)) {
			$this->relations = [
				DbPrefix .'visitor_routes' => [
					'key_column' => 'id',
					'relation_column' => 'vr_id_user',
					'onDelete' => true
				],
				DbPrefix .'users_rel_statuses' => [
					'key_column' => 'id',
					'relation_column' => 'usr_id_user',
					'onDelete' => true
				]
			];
		}

		return $this->relations;
	}
}
