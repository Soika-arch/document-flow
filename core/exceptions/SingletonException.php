<?php

namespace core\exceptions;

class SingletonException extends MainException {

	/**
	 * @param int $code діапазон кодів виключень для даного класу: 3000 - 3999.
	 * @param array $p додаткові дані.
	 * @param \Throwable $previous попереднє виключення.
	 */
	public function __construct(int $code, array $p=[], \Throwable $previous=null) {
		$message = $this->messages[$code];
		// Викликаємо конструктор батьківського класу Exception.
		parent::__construct($message, $p, $previous);
	}

	/**
	 * @return array
	 */
	protected function get_messages () {
		if (! isset($this->messages)) {
			$this->messages = [
				'3000' => '',
				'3999' => 'Невизначене виключення'
			];
		}

		return $this->messages;
	}
}
