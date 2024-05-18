<?php

// Вид сторінки списка пагінації вхідних документів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use core\db_record\incoming_documents_registry;

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

if (isset($d['documents']) && $d['documents']) {
	if (isset($d['Pagin']) && ($d['Pagin']->getNumPages() > 1)) e($d['Pagin']->toHtml());

	e('<div>');

		foreach ($d['documents'] as $docRow) {
			$Doc = new incoming_documents_registry(null, $docRow);
			$num = $d['Pagin']->getCurrentPageFirstItem();

			e('<div>');
				e('<span class="num">'. $num .'. </span>'. $Doc->DocumentTitle->_title);
			e('</div>');
		}

	e('</div>');
}

require $this->getViewFile('/inc/footer');
