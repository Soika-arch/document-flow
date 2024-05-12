<?php

// Вид сторінки адмін-панелі списка користувачів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');
// Зміни для ptmkr 2
require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

if (isset($d['usersData']) && $d['usersData']) {
	e('<div class="admin-users_list">');

		if (isset($d['usersData']['pagin']) && $d['usersData']['pagin']) {
			dd($d['usersData']['pagin'], __FILE__, __LINE__,1);
		}

		foreach ($d['users'] as $usRow) {
			e('<div class="user-data">');

				$profileURL = url('');
				$delURL = url('', ['del_user' => $usRow['us_id']]);
				$delIMG = url('/img/delete.png');

				e('<div class="user-login">');
					e('<a href="'. $profileURL .'">'. $usRow['us_login'] .'</a>');
				e('</div>');

				e('<div class="user-control-buttons">');
					e('<a href="'. $delURL .'"><img class="img-button" src="'. $delIMG .
						'" title="Видалити користувача"></a>');
				e('</div>');

			e('</div>');
		}

	e('</div>');
}

require $this->getViewFile('/inc/footer');
