<?php

namespace core;

use \core\db_record\users;
use \core\db_record\visitor_routes;

class User extends users {

	protected string $ip;
	protected string $userAgent;

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		parent::__construct($id, $dbRow);
	}

	/**
	 * @return string
	 */
	protected function get_ip () {
		if (! isset($this->ip)) $this->ip = getUserIp();

		return $this->ip;
	}

	/**
	 * @return string
	 */
	protected function get_userAgent () {
		if (! isset($this->userAgent)) $this->userAgent = getUserAgent();

		return $this->userAgent;
	}

	/**
	 * Збереження статуса пацієнта по вказаному id статуса.
	 * @return false|$this
	 */
	public function setStatus (int $idStatus) {
		// Перевірка існування статуса
		$SQL = db_getSelect();

		$SQL
			->columns(['uss_id'])
			->from(DbPrefix .'user_statuses')
			->where('uss_id', '=', $idStatus);

		// Статуса з id $idStatus не знайдено.
		if (! db_selectCell($SQL)) return false;

		$this->get_Status();

		if ($this->Status->_id !== $idStatus) {
			$this->UserRelStatus->delete();
			$this->UserRelStatus = new UserRelStatus(0);
			$nowDt = date('Y-m-d H:i:s');

			$this->UserRelStatus->set([
				'usr_id_user' => $this->_id,
				'usr_id_status' => $idStatus,
				'usr_add_date' => $nowDt,
				'usr_change_date' => $nowDt
			]);

			unset($this->Status);
		}

		return $this;
	}

	/**
	 * Додає новий запис у таблицю visitor_routes і створює відповідний об'єкт моделі.
	 * @return $this
	 */
	public function createVR () {
		$this->VR = new visitor_routes(null);
		$this->get_dbRow();

		$this->VR->set([
			'vr_id_user' => (! is_null($this->_id)) ? $this->_id : 0,
			'vr_ip' => $this->get_ip(),
			'vr_uri' => URI,
			'vr_user_agent' => $this->get_userAgent(),
			'vr_queries_count' => Db::getInstance()->queriesCounter,
			'vr_execution_time' => 0,
			'vr_add_date' => date('Y-m-d H:i:s')
		]);

		return $this;
	}

	/**
	 * Оновлення запису visitor_routes.
	 * @param float Час завершення виконання скрипта програми в секундах з точністю до стотисячних.
	 */
	public function upVR (float $exMktEnd=0): self {
		$this->get_dbRow();

		$this->VR->update([
			'vr_id_user' => isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0,
			'vr_queries_count' => db_Db()->queriesCounter,
			'vr_execution_time' => $exMktEnd ?
				$exMktEnd : round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 5)
		]);

		return $this;
	}

	/**
	 * Верифікація користувача по вказаному паролю.
	 */
	public function userVerify (string $password) {

    return password_verify($password, $this->_password_hash);
	}

	/**
	 * Збереження даних авторизованого користувача в сесії.
	 */
	public function authentication () {
		$_SESSION['user']['id'] = $this->_id;
		$_SESSION['user']['login'] = $this->_login;
		// Часова мітка вторизації користувача в секундах з точністю до міліонної.
		$_SESSION['user']['loginTimestamp'] = microtime(true);
		// Часова мітка останнього запиту користувача до сервера.
		$_SESSION['user']['lastRequestTimestamp'] = microtime(true);

		// Устанавливаем время жизни сессии в секундах
    ini_set('session.gc_maxlifetime', SessionTimeout);
    ini_set('session.cookie_lifetime', SessionTimeout);

    // Обновление времени жизни сессии при каждом запросе
    if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), $_COOKIE[session_name()], time() + SessionTimeout, "/");
    }
	}

	/**
	 * @return visitor_routes
	 */
	public function getLastVisitTime (int $idUser, string $format='d.m.Y H:i') {
		$SQL = db_getSelect();

		$SQL
			->columns(['vr_add_date'])
			->from(DbPrefix .'visitor_routes')
			->where('vr_id_user', '=', $idUser)
			->orderBy('vr_add_date desc')
			->limit(1);

		if ($vrAddDate = db_selectCell($SQL)) return tm_getDatetime($vrAddDate)->format($format);

		return false;
	}

	/**
	 * Повертає true, якщо користувач має непрочитані повідомлення.
	 * @return bool
	 */
	public function getUnreadMessagesCount () {
		$SQL = db_getSelect();

		$SQL
			->columns([$SQL->raw('count(usm_id) as c')])
			->from(DbPrefix .'user_messages')
			->where('usm_id_user', '=', $this->_id)
			->where('usm_read', '=', 'n');

		return db_selectCell($SQL);
	}
}
