<?php

namespace core;

use core\db_record\users_rel_statuses;

class UserRelStatus extends users_rel_statuses {

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		parent::__construct($id, $dbRow);
	}
}
