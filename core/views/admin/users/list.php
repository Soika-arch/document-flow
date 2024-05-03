<?php

// Вид сторінки адмін-панелі списка користувачів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

if (isset($_GET['del_user'])) {
	dd($_GET, __FILE__, __LINE__,1);
}

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (isset($d['errors'])) require $this->getViewFile('/inc/errors');

if ($d['users']) {
	e('<div class="admin-users_list">');

		foreach ($d['users'] as $usRow) {
			e('<div>');
				e('<a href="'. url('', ['del_user' => $usRow['us_id']]) .'">'. $usRow['us_login'] .'</a>');
			e('</div>');
		}

	e('</div>');
}

require $this->getViewFile('/inc/footer');
