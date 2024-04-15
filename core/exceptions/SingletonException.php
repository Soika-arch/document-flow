<?php

namespace core\exceptions;

class SingletonException extends MainException {

	// int $code диапазон для данного класса: 3000 - 3999.
	// array $p додаткові дані.
	public function __construct(int $code, array $p=[], \Throwable $previous=null) {
		$message = $this->messages[$code];
		// Викликаємо конструктор батьківського класу Exception.
		parent::__construct($message, $code, $previous);
	}

	/**
	 * @return array
	 */
	private function get_messages () {
		if (! isset($this->messages)) {
			$this->messages = [
				'3000' => '',
				'3999' => 'Невизначене виключення'
			];
		}

		return $this->message;
	}
}
