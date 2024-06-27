<?php

// Вид сторінки створення cron завдання адмін-панелі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="fm">');
	e('<form name="fm_cronAdd" action="'. url('/ap/crons/add') .'" method="post">');

		e('<div>');
			e('<label for="cMethodName">Назва метода контролера<label>');
			e('<input id="cMethodName" type="text" name="cMethodName" pattern="^t\d{4}$" required>');
		e('</div>');

		e('<div>');
			e('<label for="cDescription">Опис<label>');
			e('<textarea id="cDescription" name="cDescription" required></textarea>');
		e('</div>');

		e('<div>');
			e('<label for="cSchedule">Розклад<label>');
			e('<input id="cSchedule" type="text" name="cSchedule" required pattern="^(\*|([0-5]?\d))'.
				' (\*|([01]?\d|2[0-3])) (\*|([01]?\d|2[0-9]|3[01])) (\*|(0?[1-9]|1[0-2])) (\*|([0-7]))$">');
		e('</div>');

		e('<div>');
			e('<label for="isActive">Активація<label>');
			e('<select name="isActive" required>');
				e('<option value="y">Активний</option>');
				e('<option value="n">Виключений</option>');
			e('</select>');
		e('</div>');

		e('<div>');
			e('<label for="cParameters">Параметри<label>');
			e('<textarea id="cParameters" name="cParameters"></textarea>');
		e('</div>');

		e('<div>');
			e('<button type="submit" name="bt_addCron">Додати</button>');
		e('</div>');

	e('</form>');
e('</div>');

require $this->getViewFile('/inc/footer');
