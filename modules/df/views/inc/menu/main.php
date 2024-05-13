<?php

// Головне меню ЕД.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$url = url('/df');

e('<div class="df-main-menu">');

	e('<div>');
		e('<a href="'. $url .'/document-registration/type-selection">Зареєструвати документ</a>');
	e('</div>');

e('</div>');
