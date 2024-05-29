<?php

// Головне меню ЕД.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$url = url('/df');

e('<div class="secondary-menu">');

	e('<div>');
		e('<a href="'. $url .'">Журнал документів</a>');
	e('</div>');

	if ($Us->Status->_access_level < 4) {
		e('<div>');
			e('<a href="'. $url .'/document-registration/source-selection">Додати документ</a>');
		e('</div>');
	}

	e('<div>');
		e('<a href="'. $url .'/search">Пошук</a>');
	e('</div>');

	if (isset($_SESSION['getParameters'])) {
		e('<div>');
			e('<a href="'. url(null, ['clear' => 'y']) .'"><img class="img-button" src="'.
				url('/') .'/img/clear.png" title="Очистити фільтр"></a>');
		e('</div>');
	}

e('</div>');
