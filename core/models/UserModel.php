<?php

namespace core\models;

use core\Header;
use core\Post;
use core\Registry;
use core\User;

/**
 * Модель користувачів застосунка.
 */
class UserModel extends MainModel {

	/**
	 * Перевірка даних авторизації користувача.
	 */
	public function login (Post $Post) {
		$login = $Post->post['login'];
		$userRow = $this->getUserRowByLogin($login);

		if (! $userRow) {
			$_SESSION['errors'][1] = 'Користувача з логіном '. $login .' не знайдено';
		}
		else {
			/** @var \core\User */
			$Us = new User($userRow['us_id']);

			if ($Us->userVerify($Post->post['password'])) {
				// Авторизація користувача.

				// Заміна об'єкту користувача в єдиному реєстрі об'єктів на авторизованого користувача.
				/** @var \core\User */
				$Us = Registry::getInstance()->replace('Us', new User($userRow['us_id']));

				$Us->authentication();
			}
		}

		Header::getInstance()
			->addHeader('Location: '. url('/'), __FILE__, __LINE__)
			->send();
	}

	/**
	 * Віхід користувача із системи.
	 */
	public function logout () {
		$_SESSION['user'] = [];

		// Час завершення виконання скрипта програми в секундах з точністю до стотисячних.
		$exMktEnd = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 5);

		Registry::getInstance()->get('Us')->upVR($exMktEnd);

		Header::getInstance()
			->addHeader('Location: '. url('/'), __FILE__, __LINE__)
			->send();
	}

	/**
	 * Отримання запису користувача по логіну.
	 * @return
	 */
	protected function getUserRowByLogin (string $login) {
		$SQL = db_getSelect();

		$SQL->columns(['*'])->from(DbPrefix .'users')->where('us_login', '=', $login);

		return db_selectRow($SQL);
	}
}
