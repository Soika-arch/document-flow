<?php

namespace core\exceptions;

class MainException extends \Exception {

	protected array $messages;

	// int $code діапазон для даного класу: 1000 – 1999.
	// array $p додаткові дані.
	public function __construct(int $code, array $p=[], \Throwable $previous=null) {
		if (! isset($this->messages)) $this->get_messages();

		// Викликаємо конструктор батьківського класу Exception.
		parent::__construct($this->messages[$code], $code, $previous);
	}

	/**
	 * @return array
	 */
	private function get_messages () {
		if (! isset($this->messages)) {
			$this->messages = [
				'1000' => '',
				'1999' => 'Невизначене виключення'
			];
		}

		return $this->message;
	}

	/**
	 *
	 */
	public function printMsg () {
		dd($this, __FILE__, __LINE__,1);
	}
}
