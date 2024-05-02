<?php

// Вид головної сторінки адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (isset($d['errors'])) require $this->getViewFile('/inc/errors');

e('<div class="admin-main-menu">');
	e('<div>');
		e('<a href="'. url('users') .'">Користувачі</a>');
	e('</div>');
e('</div>');

require $this->getViewFile('/inc/footer');
