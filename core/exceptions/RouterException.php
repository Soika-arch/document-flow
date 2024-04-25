<?php

namespace core\exceptions;

class RouterException extends MainException {

	/**
	 * @param int $code діапазон кодів виключень для даного класу: 4000 - 4999.
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
				// '4000' => 'Не знайдено метод для отримання властивості класу',
				// '4999' => 'Невизначене виключення'
			];
		}

		return $this->messages;
	}
}
