<?php

// Вид сторінки профіля користувача.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="user-profile">');

	e('<div>');
		e('<span class="header-field">Користувач</span>');
		e('<span>'. $d['User']->_login .'</span>');
	e('</div>');

	e('<div>');
		e('<span class="header-field">Останнє відвідування</span>');
		e('<span>'. $d['User']->getLastVisitTime($d['User']->_id) .'<span>');
	e('</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
