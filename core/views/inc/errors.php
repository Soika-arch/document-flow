<?php

// Головний вид виводу помилок.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

e('<div class="user-errors">');

	foreach ($_SESSION['errors'] as $key => $msg) {
		e('<div class="error">'. $msg .'</div>');

		unset($_SESSION['errors'][$key]);
	}

e('</div>');
