<?php

namespace core\exceptions;

class DbRecordException extends MainException {

	/**
	 * @param int $code діапазон кодів виключень для даного класу: 2000 - 2999.
	 * @param array $p додаткові дані.
	 * @param \Throwable $previous попереднє виключення.
	 */
	public function __construct(int $code, array $p=[], \Throwable $previous=null) {
		$this->get_messages();

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
				'2000' => 'Не знайдено метод для отримання властивості класу',
				'2001' => 'Властивість класу не знайдено',
				'2999' => 'Невизначене виключення'
			];
		}

		return $this->messages;
	}
}
