<?php

// Головний вид виводу системних повідомлень.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

e('<div class="sys-messages">');

	foreach ($_SESSION['sysMessages'] as $key => $msg) {
		e('<div class="error">'. $msg .'</div>');

		sess_deleteSysMessage($key);
	}

e('</div>');
