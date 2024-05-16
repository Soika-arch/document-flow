<?php

// Головне меню ЕД.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$url = url('/df');

e('<div class="secondary-menu">');

	e('<div>');
		e('<a href="'. $url .'/document-registration/source-selection">Зареєструвати документ</a>');
	e('</div>');

e('</div>');
