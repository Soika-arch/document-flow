<?php

// Головне меню сайта.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

e('<div class="main-menu">');

	e('<div>');
		e('<a href="'. url('/') .'">Home</a>');
	e('</div>');

	if ($Us->_id && ($Us->_id > 0)) {
		e('<div>');
			e('<a href="'. url('/user/logout') .'">Вийти</a>');
		e('</div>');
	}

e('</div>');
