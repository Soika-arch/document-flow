<?php

// Функції взаємодії з класом \core\Header.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use core\Header;

/**
 * Повертає об'єкт класу Header.
 */
function hd_Hd (): Header {

	return Header::getInstance();
}

/**
 * Додавання заголовка і відправка усіх збережених заголовків.
 */
function hd_sendHeader (string $header, string $fname, int $line, bool $isExit=true) {
	hd_Hd()->addHeader($header, $fname, $line)->send($isExit);
}
