<?php

// Головне меню адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$url = url('/'. URIAdmin);

e('<div class="secondary-menu">');

	e('<div>');
		e('<a href="'. $url .'/users">Користувачі</a>');
	e('</div>');

	e('<div>');
		e('<a href="'. $url .'/security">Безпека</a>');
	e('</div>');

e('</div>');
