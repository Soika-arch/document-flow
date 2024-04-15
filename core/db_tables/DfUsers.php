<?php

namespace core\db_tables;

class DfUsers extends Table {

	/**
	 *
	 */
	public function __construct () {

	}

	/**
	 * @return array
	 */
	protected function get_relations () {
		if (! isset($this->relations)) {
			$this->relations = [
				'df_users_rel_groups' => [
					'key' => 'ug_id',
					'relation' => 'urg_id_user'
				]
			];
		}
	}
}
