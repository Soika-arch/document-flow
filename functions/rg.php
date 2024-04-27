<?php

// Функції взаємодії з класом \core\Registry.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use core\Registry;

/**
 * Повертає об'єкт класу Registry.
 */
function rg_Rg (): Registry {

	return Registry::getInstance();
}
