<?php

namespace core\exceptions;

class DbException extends MainException {

	/**
	 * @param int $code діапазон кодів виключень для даного класу: 5000 - 5999.
	 * @param array $p додаткові дані.
	 * @param \Throwable $previous попереднє виключення.
	 */
	public function __construct(int $code, array $p=[], \Throwable $previous=null) {
		// Викликаємо конструктор батьківського класу Exception.
		parent::__construct($code, $p, $previous);
	}

	/**
	 * Повертає властивість $messages
	 * @return array
	 */
	protected function get_messages () {
		if (! isset($this->messages)) {
			$this->messages = [
				'5000' => 'Отримано більше одного запису БД',
				'5001' => 'Видалено більше одного запису БД',
				'5002' => 'У БД information_schema не знайдено даних таблиці',
				'5999' => 'Невизначене виключення'
			];
		}

		return $this->messages;
	}
}
