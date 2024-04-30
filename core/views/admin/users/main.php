<?php

// Вид головної сторінки управління користувачами адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');
$url = url('');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (isset($d['errors'])) require $this->getViewFile('/inc/errors');

e('<div class="admin-main-menu">');

	e('<div>');
		e('<a href="'. $url .'">Користувачі</a>');
	e('</div>');

	e('<div>');
		e('<a href="'. $url .'/add">Додати користувача</a>');
	e('</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
