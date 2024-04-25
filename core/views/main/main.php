<?php

// Вид main сторінки.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

require $this->getViewFile('/inc/header');

if (isset($d['errors'])) require $this->getViewFile('/inc/errors');

e('<div class="form-user_auth">');
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

require $this->getViewFile('/inc/footer');
