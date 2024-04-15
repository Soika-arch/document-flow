<?php

namespace core\exceptions;

class RouterException extends MainException {

	private array $messages = [
		'4000' => '',
		'4999' => 'Невизначене виключення'
	];

	// int $code діапазон для даного класу: 4000 – 4999.
	public function __construct(string $message='', int $code=0, \Throwable $previous=null) {
		// Викликаємо конструктор батьківського класу Exception.
		parent::__construct($message, $code, $previous);
	}
}
