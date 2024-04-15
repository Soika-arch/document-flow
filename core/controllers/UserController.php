<?php

namespace core\controllers;

use core\db_tables\DfUsers;

class UserController extends MainController {

	public function __construct () {
		echo __METHOD__;
	}

	/**
	 *
	 */
	public function addAction () {
		$TUser = new DfUsers();
		dd($TUser, __FILE__, __LINE__,1);
	}
}
