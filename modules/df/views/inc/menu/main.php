<?php

// Головне меню ЕД.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$url = url('/df');

e('<div class="secondary-menu">');

	if ($Us->Status->_access_level < 4) {
		e('<div>');
			e('<a href="'. $url .'">Журнал документів</a>');
		e('</div>');

		e('<div>');
			e('<a href="'. $url .'/document-registration/source-selection">Додати документ</a>');
		e('</div>');
	}

e('</div>');
