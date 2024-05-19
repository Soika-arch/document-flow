<?php

// Вид сторінки адмін-панелі списка користувачів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

if (isset($d['usersData']) && $d['usersData']) {
	e('<div class="admin-users_list">');

		if (isset($d['usersData']['Pagin']) && ($d['usersData']['Pagin']->getNumPages() > 1)) {
			e($d['usersData']['Pagin']->toHtml());
		}

		e('<div class="users">');

			foreach ($d['usersData']['users'] as $usRow) {
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

	e('</div>');
}

require $this->getViewFile('/inc/footer');
