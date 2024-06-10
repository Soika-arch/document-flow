<?php

// Звіт по внутрішнім документам на контролі.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use \core\db_record\internal_documents_registry;

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

if (isset($d['documents']) && $d['documents']) {
	if ($d['Pagin']->getNumPages() > 1) e($d['Pagin']->toHtml());

	e('<div class="document-list">');

		e('<div class="doc-header">');
			e('<span class="header-num">№</span>');
			e('<span class="header-title">Назва</span>');
			e('<span class="header-date">Дата документа</span>');
			e('<span class="header-number">№ документа</span>');
			e('<span class="header-executor">Призначений виконавець</span>');
			e('<span class="header-executor">Тип контролю</span>');
			e('<span class="header-location">Місцезнаходження оригінала</span>');
		e('</div>');

		$num = $d['Pagin']->getCurrentPageFirstItem();

		foreach ($d['documents'] as $docRow) {
			$Doc = new internal_documents_registry(null, $docRow);

			$docTitle = '<a href="'. $Doc->cardURL .'" target="_blank" title="Картка документа">'.
				$Doc->DocumentTitle->_title .'</a>';

			e('<div class="doc-block">');
				e('<span class="doc-num">'. $num++ .'. </span>');
				e('<span class="doc-title">'. $docTitle .'</span>');

				e('<span class="doc-date" title="Дата документа">'.
					date('d.m.Y', strtotime($Doc->_document_date)) .'</span>');

				e('<span class="doc-number">'. strtoupper($Doc->displayedNumber) .'</span>');

				$executorLogin = $Doc->ExecutorUser ? $Doc->ExecutorUser->_login : '';

				if ($Doc->_date_of_receipt_by_executor) {
					$isReceivedStyle = ' style="border:solid 1px green;"';
				}
				else {
					$isReceivedStyle = ' style="border:solid 1px red;"';
				}

				e('<span class="doc-executor" title="Виконавець"'. $isReceivedStyle .'>'.
					$executorLogin .'</span>');

				$docControlType = $Doc->ControlType->_id ? $Doc->ControlType->_name : '';

				e('<span class="doc-resolution" title="Тип контролю">'. $docControlType .'</span>');

				$docLocation = $Doc->DocumentLocation ? $Doc->DocumentLocation->_name : '';

				e('<span class="doc-location" title="Місцезнаходження документа">'. $docLocation .'</span>');
			e('</div>');
		}

	e('</div>');
}

require $this->getViewFile('/inc/footer');