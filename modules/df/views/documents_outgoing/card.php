<?php

// Вид сторінки карточки вихідного документа.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

$Doc = $d['Doc'];

e('<div class="document-card">');

	e('<div>');
		e('<span class="card-header">Назва:</span>');
		e('<span class="card-title">'. $Doc->DocumentTitle->_title .'.</span>');
	e('</div>');

	e('<div>');
		e('<span class="card-header">Номер документа:</span>');
		e('<span class="card-number">'. strtoupper($Doc->displayedNumber) .'.</span>');
	e('</div>');

	e('<div>');
		e('<span class="card-header">Реєстратор документа:</span>');
		e('<span class="card-registrar">'. $Doc->getRegistrarLogin() .'.</span>');
	e('</div>');

	if ($Doc->IncomingDocument) {
		$docIncURL = $Doc->IncomingDocument->cardURL;
		$displayedNumber = $Doc->IncomingDocument->displayedNumber;

		$docIncLink = '<a href="'. $docIncURL .'" target="_blank">'. $displayedNumber .'</a>';
	}
	else {
		$docIncLink = '';
	}

	e('<div>');
		e('<span class="card-header">Відповідний вхідний:</span>');
		e('<span class="card-registrar">'. $docIncLink .'.</span>');
	e('</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
