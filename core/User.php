<?php

namespace core;

use core\db_record\users;
use core\db_record\users_rel_statuses;
use core\db_record\user_statuses;
use core\db_record\visitor_routes;

class User extends users {

	private string $ip;
	private string $userAgent;
	private visitor_routes $VR;
	// Зв'язок користувача з його статусом.
	private UserRelStatus $UserRelStatus;
	// Статус користувача.
	private user_statuses $Status;

	/**
	 *
	 */
	public function __construct (int|null $id, array $dbRow=[]) {
		parent::__construct($id, $dbRow);
	}

	/**
	 * @return user_statuses
	 */
	protected function get_Status () {

		return $this->get_UserRelStatus()->UserStatus;
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
	 * @return visitor_routes
	 */
	protected function get_VR () {
		if (isset($this->VR)) return $this->VR;
	}

	/**
	 * @return users_rel_statuses
	 */
	protected function get_UserRelStatus () {
		if (! isset($this->UserRelStatus)) {
			$SQL = db_getSelect();
			$tName = DbPrefix .'users_rel_statuses';

			$SQL
				->columns([$tName .'.*'])
				->from($tName)
				->join(DbPrefix .'users', 'us_id', '=', 'urs_id_user')
				->where('us_id', '=', $this->_id);

			$row = db_selectRow($SQL);

			$this->UserRelStatus = new UserRelStatus($row['urs_id'], $row);
		}

		return $this->UserRelStatus;
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
	 * @return $this
	 */
	public function upVR (float $exMktEnd) {
		$this->get_dbRow();

		$this->VR->update([
			'vr_id_user' => isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0,
			'vr_queries_count' => db_Db()->queriesCounter,
			'vr_execution_time' => $exMktEnd
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
	}
}
