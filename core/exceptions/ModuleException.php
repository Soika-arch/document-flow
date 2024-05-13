<?php

namespace core\exceptions;

use core\exceptions\MainException;

class ModuleException extends MainException {

	/**
	 * @param int $code діапазон кодів виключень для даного класу: 7000 - 7999.
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
				'7000' => 'Відсутній клас модуля',
				'7999' => 'Невизначене виключення'
			];
		}

		return $this->messages;
	}
}
