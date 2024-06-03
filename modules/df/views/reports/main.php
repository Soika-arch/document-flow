<?php

// Вид головної сторінки звітів документів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div id="notification" class="notification"></div>');

e('<div class="fm df-selecting_source_document">');

	e('<form>');
		e('<div class="label_block">');
			e('<label for="documentDirection">Типи документів</label>');
			e('<select id="documentDirection" name="documentDirection">');
				e('<option value=""></option>');
				e('<option value="inc">Вхідні</option>');
				e('<option value="out">Вихідні</option>');
				e('<option value="int">Внутрішні</option>');
			e('</select>');
		e('</div>');
	e('</form>');

	e('<div id="incomingDocuments">');
		e('<a href="'. $url .'/reports/r0001">Невиконані документи</a><br><br>');
		e('<a href="'. $url .'/reports/r0003">Виконавці, які не виконали документи</a><br><br>');
	e('</div>');

	e('<div id="outgoingDocuments">');
		e('<a href="'. $url .'/reports/r0002">Документи на конткролі</a><br><br>');
	e('</div>');

	e('<div id="internalDocuments">');
		e('<a href="'. $url .'/reports/r0002">Невиконані документи</a><br><br>');
		e('<a href="'. $url .'/reports/r0003">Документи на конткролі</a><br><br>');
	e('</div>');

e('</div>');

e('<script src="/js/main.js"></script>');
e('<script src="/js/df_reports.js"></script>');

require $this->getViewFile('/inc/footer');
