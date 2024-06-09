<?php

// Вид сторінки додавання нового користувача адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="fm">');
	e('<form name="fm_userAdd" action="'. url() .'" method="post">');

		e('<div>');
			e('<label for="login">Логін<label>');
			e('<input type="text" name="login" required>');
		e('</div>');

		e('<div>');
			e('<label for="password">Пароль<label>');
			e('<input type="text" name="password" required>');
		e('</div>');

		e('<div>');
			e('<label for="email">E-mail<label>');
			e('<input type="text" name="email" required>');
		e('</div>');

		e('<div>');
			e('<label for="status">Статус<label>');
			e('<select name="status" required>');

				e('<option></option>');

				foreach ($d['statuses'] as $stData) {
					e('<option value="'. $stData['uss_id'] .'">'. $stData['uss_description'] .'</option>');
				}

			e('</select>');
		e('</div>');

		e('<div>');
			e('<label for="tgId">Telegram ID<label>');
			e('<input type="number" name="tgId">');
		e('</div>');

		e('<div>');
			e('<button type="submit" name="bt_addUser">Додати</button>');
		e('</div>');

	e('</form>');
e('</div>');

require $this->getViewFile('/inc/footer');
