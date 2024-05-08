<?php

// Головне меню адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$url = url('/'. URIAdmin);

e('<div class="admin-main-menu">');

	e('<div>');
		e('<a href="'. $url .'/users">Користувачі</a>');
	e('</div>');

e('</div>');
