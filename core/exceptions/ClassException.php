<?php

namespace core\exceptions;

use core\exceptions\MainException;

class ClassException extends MainException {

	// int $code діапазон для даного класу: 2000 – 2999.
	// array $p додаткові дані.
	public function __construct(int $code, array $p=[], \Throwable $previous=null) {
		$this->get_messages();

		// Викликаємо конструктор батьківського класу Exception.
		parent::__construct($code, $p, $previous);
	}

	/**
	 * @return array
	 */
	private function get_messages () {
		if (! isset($this->messages)) {
			$this->messages = [
				'2000' => 'Не знайдено метод для отримання властивості класу',
				'2001' => 'Властивість класу не знайдено',
				'2999' => 'Невизначене виключення'
			];
		}

		return $this->message;
	}
}
