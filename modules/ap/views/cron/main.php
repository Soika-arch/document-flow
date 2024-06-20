<?php

// Вид головної сторінки управління cron задачами адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="cron-main-menu">');

	e('<div class="menu-elem">');
		e('<a href="'. url('/ap/crons/list') .'">Список cron задач</a>');
	e('</div>');

	e('<div>');
		e('<a href="'. url('/ap/crons/add') .'">Створити cron завдання</a>');
	e('</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
