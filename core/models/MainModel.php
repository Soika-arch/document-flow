<?php

namespace core\models;

/**
 * Базова модель.
 */
class MainModel {

	use \core\traits\SetGet;

	/**
	 *
	 */
	public function __construct () {
		// dd($this, __FILE__, __LINE__);
	}

	/**
	 * Повертає дані для сторінки ''.
	 * @return array
	 */
	public function getMain () {
		$d['title'] = 'Авторизація користувача';

		return $d;
	}
}
