<?php

// Головне меню сторінки ЕД - Типи документів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$url = url('');

e('<div class="df-document-types-menu_1">');

	e('<div>');
		e('<a href="'. $url .'/list">Усі типи документів</a>');
	e('</div>');

	e('<div>');
		e('<a href="'. $url .'/add">Додати новий тип документів</a>');
	e('</div>');

e('</div>');
