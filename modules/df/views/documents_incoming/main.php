<?php

// Вид головної сторінки вхідних документів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="df-document-types-menu_1">');

	e('<div>');
		e('<a href="'. $url .'/documents-incoming/list">Список вхідних документів</a>');
	e('</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
