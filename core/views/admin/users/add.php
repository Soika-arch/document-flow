<?php

// Вид сторінки додавання нового користувача адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (isset($_SESSION['sysMessages'])) require $this->getViewFile('/inc/sys_messages');
if (isset($d['errors'])) require $this->getViewFile('/inc/errors');

e('<div class="form-add_user">');
	e('<form name="fm_userAdd" action="'. url() .'" method="post">');

		e('<div>');
			e('<label for="login">Логін<label>');
			e('<input type="text" name="login">');
		e('</div>');

		e('<div>');
			e('<label for="password">Пароль<label>');
			e('<input type="text" name="password">');
		e('</div>');

		e('<div>');
			e('<label for="email">E-mail<label>');
			e('<input type="text" name="email">');
		e('</div>');

		e('<div>');
			e('<label for="status">Статус<label>');
			e('<select name="status">');

			foreach ($d['statuses'] as $stData) {
				e('<option value="'. $stData['uss_id'] .'">'. $stData['uss_description'] .'</option>');
			}

			e('</select>');
		e('</div>');

		e('<div>');
			e('<button type="submit" name="bt_addUser">Додати</button>');
		e('</div>');

	e('</form>');
e('</div>');

require $this->getViewFile('/inc/footer');
