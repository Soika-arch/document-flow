<?php

// Вид сторінки адмін-панель - безпека.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="security-main-menu">');

	e('<div>');
		e('<a href="'. url('/ap/security/visits-list') .'">Відвідувачі</a>');
	e('</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
