<?php

namespace core\exceptions;

use core\exceptions\MainException;

class ClassException extends MainException {

	/**
	 * @param int $code діапазон кодів виключень для даного класу: 6000 - 6999.
	 * @param array $p додаткові дані.
	 * @param \Throwable $previous попереднє виключення.
	 */
	public function __construct(int $code, array $p=[], \Throwable $previous=null) {
		if (! isset($this->messages)) $this->get_messages();

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
				'6000' => 'Помилка виконання метода класа типу DbRecord::update',
				'6001' => 'Властивість класу не знайдена',
				'6999' => 'Невизначене виключення'
			];
		}

		return $this->messages;
	}
}
