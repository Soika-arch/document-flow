<?php

// Вид сторінки повідомлення користувача.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="user-message">');

	e('<h3 class="msg-header">'. $d['Message']->_header .'</h3>');
	e('<div class="msg-content">'. $d['Message']->_msg .'</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
