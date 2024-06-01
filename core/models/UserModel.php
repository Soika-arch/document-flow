<?php

namespace core\models;

use core\Post;
use core\Registry;
use core\User;

/**
 * Модель користувачів застосунка.
 */
class UserModel extends MainModel {

	/**
	 * Перевірка даних авторизації користувача.
	 * @return bool
	 */
	public function login (Post $Post) {
		$login = $Post->post['login'];
		$Us = $this->createUserByLogin($login);

		if ($Us->_id) {
			if ($Us->userVerify($Post->post['password'])) {
				// Авторизація користувача.

				// Заміна об'єкту користувача в єдиному реєстрі об'єктів на верифікованого користувача
				// та одразу аутентифікація користувача.
				Registry::getInstance()->replace('Us', $Us)->authentication();

				return true;
			}
		}

		return false;
	}

	/**
	 * Вихід користувача із системи.
	 * @return bool
	 */
	public function logout () {
		$_SESSION['user'] = [];

		// Час завершення виконання скрипта програми в секундах з точністю до стотисячних.
		$exMktEnd = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 5);

		Registry::getInstance()->get('Us')->upVR($exMktEnd);

		return true;
	}

	/**
	 * Отримання об'єкта \core\User по логіну.
	 * @return User
	 */
	protected function createUserByLogin (string $login) {
		$idUser = $this->selectCellByCol(DbPrefix .'users', 'us_login', $login, 'us_id');

		return new User($idUser);
	}

	/**
	 * @return array
	 */
	public function profilePage () {
		$get = rg_Rg()->get('Get')->get;

		$d['title'] = 'Профіль користувача';
		$userRow = $this->selectRowByCol(DbPrefix .'users', 'us_login', $get['l']);
		$d['User'] = new User($userRow['us_id'], $userRow);

		return $d;
	}
}
