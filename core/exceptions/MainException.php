<?php

namespace core\exceptions;

/**
 * Базовий клас виключень.
 */
class MainException extends \Exception {

	// Масив повідомлень виключень. Повідомлення унікальні для кожного класа нащадка.
	protected array $messages;
	protected array $p;

	/**
	 * @param int $code діапазон кодів виключень для даного класу: 1000 - 1999.
	 * @param array $p додаткові дані.
	 * @param \Throwable $previous попереднє виключення.
	 */
	public function __construct(int $code, array $p=[], \Throwable $previous=null) {
		if (! isset($this->messages)) $this->get_messages();

		$this->p = $p;

		// Викликаємо конструктор батьківського класу Exception.
		parent::__construct($this->messages[$code], $code, $previous);
	}

	/**
	 * Повертає властивість $messages
	 * @return array
	 */
	protected function get_messages () {
		if (! isset($this->messages)) {
			$this->messages = [
				'1000' => 'Файл відсутній, або недоступний',
				'1999' => 'Невизначене виключення'
			];
		}

		return $this->messages;
	}

	/**
	 * Вивід даних виключення
	 */
	public function printMsg () {
		$data['this'] = $this;

		if (isset($this->p)) $data['p'] = $this->p;

		dd($data, __FILE__, __LINE__,1);
	}
}
