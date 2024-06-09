<?php

// Вид сторінки зміни даних користувача адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="fm">');
	e('<form name="bt_editUser" action="'. url() .'" method="post">');

		e('<div>');
			e('<label for="login">Логін<label>');
			e('<input type="text" name="login" value="'. $d['User']->_login .'">');
		e('</div>');

		e('<div>');
			e('<label for="email">E-mail<label>');
			e('<input type="text" name="email" value="'. $d['User']->_email .'">');
		e('</div>');

		e('<div>');
			e('<label for="status">Статус<label>');
			e('<select name="status">');

			foreach ($d['statuses'] as $stData) {
				if ($stData['uss_id'] === $d['User']->Status->_id) {
					e('<option value="'. $stData['uss_id'] .'" selected>'. $stData['uss_description'] .
						'</option>');
				}
				else {
					e('<option value="'. $stData['uss_id'] .'">'. $stData['uss_description'] .'</option>');
				}
			}

			e('</select>');
		e('</div>');

		e('<div>');
			e('<label for="tgId">Telegram ID<label>');
			e('<input type="number" name="tgId" value="'. $d['User']->_id_tg .'">');
		e('</div>');

		e('<div>');
			e('<button type="submit" name="bt_editUser">Змінити</button>');
		e('</div>');

	e('</form>');
e('</div>');

require $this->getViewFile('/inc/footer');
