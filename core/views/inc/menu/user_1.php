<?php

// Меню користувача 1.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

e('<div class="user-menu-1">');

	e('<div>');
		e('<a href="'. url('/') .'">'. $Us->_login .'</a>');
	e('</div>');

e('</div>');
