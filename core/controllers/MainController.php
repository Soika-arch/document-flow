<?php

namespace core\controllers;

class MainController {

	public function __construct () {
		echo __METHOD__;
	}

	/**
	 *
	 */
	public function notFoundAction () {
		dd(__METHOD__, __FILE__, __LINE__,1);
	}
}
