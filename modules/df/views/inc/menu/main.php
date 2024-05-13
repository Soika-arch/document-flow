<?php

// Головне меню ЕД.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$url = url('/df');

e('<div class="df-main-menu">');

	e('<div>');
		e('<a href="'. $url .'/document-types">Типи документів</a>');
	e('</div>');

e('</div>');
