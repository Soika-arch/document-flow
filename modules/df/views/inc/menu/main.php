<?php

// Головне меню ЕД.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$url = url('/df');

$listLinks = [
	'' => url('/df'),
	'documents-incoming' => url('/df/documents-incoming/list'),
	'documents-outgoing' => url('/df/documents-outgoing/list'),
	'documents-internal' => url('/df/documents-internal/list'),
];

$listURL = isset($listLinks[rt_Rt()->controllerURI]) ? $listLinks[rt_Rt()->controllerURI] : $url;

e('<div class="secondary-menu">');

	e('<div>');
		e('<a href="'. $listURL .'">Журнал документів</a>');
	e('</div>');

	if ($Us->Status->_access_level < 4) {
		e('<div>');
			e('<a href="'. $url .'/document-registration/source-selection">Додати документ</a>');
		e('</div>');

		e('<div>');
			e('<a href="'. $url .'/reports">Звіти</a>');
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

	if (strpos(URL, '/df/documents-incoming/card?n=') ||
			strpos(URL, '/df/documents-internal/card?n=')) {
		e('<div>');
			e('<a href="'. url('/df/print-card?n='. strtolower($d['Doc']->displayedNumber)) .
				'" target="_blank"><img class="img-button" src="'.
				url('/') .'/img/print.png" title="Друк картки"></a>');
		e('</div>');
	}

e('</div>');
