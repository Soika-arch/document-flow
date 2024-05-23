<?php

// Меню журнала документів 1.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

e('<div>');
	$url = url('/df');

	e('<div class="menu-journal-1">');
		e('<span class="elem"><a href="'. $url .'/documents-incoming/list">Вхідні</a></span>');
		e('<span class="elem"><a href="'. $url .'/documents-outgoing/list">Вихідні</a></span>');
		e('<span class="elem"><a href="'. $url .'/documents-internal/list">Внутрішні</a></span>');
	e('</div>');
e('</div>');
