<?php

// Функції взаємодії з класом \core\Router.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use \core\Router;

/**
 * @return \core\Router
 */
function rt_Rt () {

	return Router::getInstance();
}
