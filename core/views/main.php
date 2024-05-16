<?php

// Вид main сторінки.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

if (! $Us->_id || ($Us->_id === 0)) {
	// Вивід форми авторизації користувача.

	e('<div class="fm">');
		e('<form name="fm_login" action="'. url('/user/login') .'" method="post">');

			e('<div>');
				e('<label>Логін:</label>');
				e('<input type="text" name="login">');
			e('</div>');

			e('<div>');
				e('<label>Пароль:</label>');
				e('<input type="password" name="password">');
			e('</div>');

			e('<div>');
				e('<button type="submit" name="bt_loging">Увійти</button>');
			e('</div>');

		e('</form>');
	e('</div>');
}

require $this->getViewFile('/inc/footer');
