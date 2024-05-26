<?php

// Вид сторінки карточки внутрішнього документа.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

$Doc = $d['Doc'];

e('<form class="fm">');

	e('<div>');
		e('<label>Назва</label>');
		e('<input type="text" name="login" value="'. $Doc->DocumentTitle->_title .'">');
	e('</div>');

	e('<div>');
		e('<span class="card-header">Назва:</span>');
		e('<span class="card-header">'. $Doc->DocumentTitle->_title .'.</span>');
	e('</div>');

	e('<div>');
		e('<span class="card-header">Номер документа:</span>');
		e('<span class="card-header">'. strtoupper($Doc->displayedNumber) .'.</span>');
	e('</div>');

	e('<div>');
		e('<span class="card-header">Реєстратор документа:</span>');
		e('<span class="card-header">'. $Doc->getRegistrarLogin() .'.</span>');
	e('</div>');

	e('<div>');
		e('<button type="submit" name="bt_set">Змінити</button>');
	e('</div>');

e('</form>');

require $this->getViewFile('/inc/footer');
