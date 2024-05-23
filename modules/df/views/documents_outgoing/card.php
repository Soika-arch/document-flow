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

e('<div>');
	e('<span class="card-header">Назва (заголовок) документа:</span>');
	e('<span class="card-header">'. $Doc->DocumentTitle->_title .'.</span>');
e('</div>');

e('<div>');
	e('<span class="card-header">Номер документа:</span>');
	e('<span class="card-header">'. strtoupper($Doc->_number) .'.</span>');
e('</div>');

e('<div>');
	e('<span class="card-header">Реєстратор документа:</span>');
	e('<span class="card-header">'. $Doc->getRegistrarLogin() .'.</span>');
e('</div>');

require $this->getViewFile('/inc/footer');
