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
	e('<form name="fm_docDescription" action="'. url('/ap/lib/document-descriptions-add') .
		'" method="post">');

		e('<div>');
			e('<label for="docDescription">Короткий опис документа<label>');
			e('<textarea id="docDescription" name="docDescription" required></textarea>');
		e('</div>');

		e('<div>');
			e('<button type="submit" name="bt_docDescription">Додати</button>');
		e('</div>');

	e('</form>');
e('</div>');

require $this->getViewFile('/inc/footer');
