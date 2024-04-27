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
