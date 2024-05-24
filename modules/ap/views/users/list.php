<?php

// Вид сторінки адмін-панелі списка користувачів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use core\User;

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

if (isset($d['users']) && $d['users']) {
	e('<div class="admin-users_list">');

		if (isset($d['Pagin']) && ($d['Pagin']->getNumPages() > 1)) {
			e($d['Pagin']->toHtml());
		}

		e('<div class="users">');

			foreach ($d['users'] as $usRow) {
				$UsTemp = new User($usRow['us_id'], $usRow);

				e('<div class="user-data">');

					$editURL = url('/ap/users/edit', ['id' => $UsTemp->_id]);
					$delURL = url('', ['del_user' => $UsTemp->_id]);
					$delIMG = url('/img/delete.png');

					e('<div class="user-login">');
						e('<a href="'. $editURL .'" target="_blank">'. $UsTemp->_login .'</a>');
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
