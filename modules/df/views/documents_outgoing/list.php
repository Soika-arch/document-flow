<?php

// Вид сторінки списка пагінації вхідних документів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use \core\db_record\outgoing_documents_registry;

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

require $this->getViewFile('inc/menu/menu_journal_1');

if (isset($d['documents']) && $d['documents']) {
	if ($d['Pagin']->getNumPages() > 1) e($d['Pagin']->toHtml());

	e('<div>');

		$num = $d['Pagin']->getCurrentPageFirstItem();

		foreach ($d['documents'] as $docRow) {
			$Doc = new outgoing_documents_registry(null, $docRow);

			$docCardURL = url('/df/documents-outgoing/card',
				['n' => str_replace('out_', '', $Doc->_number)]);

			$docTitle = '<a href="'. $docCardURL .'" target="_blank">'. $Doc->DocumentTitle->_title .'</a>';

			e('<div>');
				e('<span class="num">'. $num++ .'. </span>');
				e('<span class="doc-title">'. $docTitle .'</span>');
				e('<span class="doc-date">'. date('d.m.Y', strtotime($Doc->_document_date)) .'</span>');
				e('<span class="doc-date">'. strtoupper($Doc->_number) .'</span>');
			e('</div>');
		}

	e('</div>');
}

require $this->getViewFile('/inc/footer');
