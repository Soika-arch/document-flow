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
		$Us = $this->createUserByLogin($login);

		if (! $Us->_id) {
			// Не знайдено користувача за вказаним логіном.

			$_SESSION['errors'][1] = 'Користувача з логіном '. $login .' не знайдено';
		}
		else {
			if ($Us->userVerify($Post->post['password'])) {
				// Авторизація користувача.

				// Заміна об'єкту користувача в єдиному реєстрі об'єктів на верифікованого користувача
				// та одразу аутентифікація користувача.
				Registry::getInstance()->replace('Us', $Us)->authentication();
			}
		}

		// Перенаправлення на головну сторінку.

		Header::getInstance()
			->addHeader('Location: '. url('/'), __FILE__, __LINE__)
			->send();
	}

	/**
	 * Вихід користувача із системи.
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
	 * Отримання об'єкта \core\User по логіну.
	 * @return User
	 */
	protected function createUserByLogin (string $login) {
		$SQL = db_getSelect();

		$SQL->columns(['us_id'])->from(DbPrefix .'users')->where('us_login', '=', $login);

		return new User(db_selectCell($SQL));
	}
}
