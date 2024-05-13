<?php

// Вид сторінки вибору джерела документа для реєстрації.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

$url = url('/df');

e('<div class="df-selecting_source_document">');

	e('<div>');
		e('<a href="'. $url .'/document-registration/incoming">Вхідний</a>');
	e('</div>');

	e('<div>');
		e('<a href="'. $url .'/document-registration/outgoing">Вихідний</a>');
	e('</div>');

	e('<div>');
		e('<a href="'. $url .'/document-registration/internal">Внутрішній</a>');
	e('</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
