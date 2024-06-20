<?php

// Вид сторінки Бібліотеки адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="lib-main-menu">');

	e('<div class="menu-elem">');
		e('<a href="'. url('/ap/lib/document-titles-add') .'">Додати назву (заголовок) документа</a>');
	e('</div>');

	e('<div>');
		e('<a href="'. url('/ap/lib/document-descriptions-add') .'">Додати короткий опис документа</a>');
	e('</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
