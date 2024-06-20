<?php

// Вид сторінки Бібліотеки адмін-панелі - форма додавання назви (заголовка) документа.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="fm">');
	e('<form name="fm_docTitle" action="'. url() .'" method="post">');

		e('<div>');
			e('<label for="docTitle">Заголовок (назва)<label>');
			e('<textarea id="docTitle" name="docTitle" required></textarea>');
		e('</div>');

		e('<div>');
			e('<button type="submit" name="bt_docTitle">Додати</button>');
		e('</div>');

	e('</form>');
e('</div>');

require $this->getViewFile('/inc/footer');
