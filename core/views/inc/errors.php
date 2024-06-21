<?php

// Головний вид виводу помилок.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

if ((Debug || (rg_Rg()->get('Us')->Status->_access_level === 1)) && isset($_SESSION['errors'])) {
	e('<div class="user-errors">');

		foreach ($_SESSION['errors'] as $key => $msg) {
			e('<div class="error">'. $msg .'</div>');

			unset($_SESSION['errors'][$key]);
		}

	e('</div>');
}

if (isset($_SESSION['userErrors'])) {
	e('<div class="user-errors">');

		foreach ($_SESSION['userErrors'] as $key => $msg) {
			e('<div class="error">'. $msg .'</div>');

			unset($_SESSION['userErrors'][$key]);
		}

	e('</div>');
}
