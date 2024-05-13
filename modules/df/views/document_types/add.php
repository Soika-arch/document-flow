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

e('<div class="form-add_dt">');
	e('<form name="fm_dtAdd" action="'. url() .'" method="post">');

		e('<div>');
			e('<label for="dtName">Назва типу документа<label>');
			e('<textarea class="dt-type_name" name="dtName"></textarea>');
		e('</div>');

		e('<div>');
			e('<label for="dtDescription">Опис<label>');
			e('<div>');
				e('<textarea name="dtDescription"></textarea>');
			e('</div>');
		e('</div>');

		e('<div>');
			e('<button type="submit" name="bt_addDt">Додати</button>');
		e('</div>');

	e('</form>');
e('</div>');

require $this->getViewFile('/inc/footer');
