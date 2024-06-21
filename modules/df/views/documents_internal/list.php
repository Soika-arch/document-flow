<?php

// Вид сторінки списка пагінації вхідних документів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use core\db_record\internal_documents_registry;

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

	e('<form name="doc_list" class="tbl doc_list" action="'.
		url('/df/documents-internal/list') .'" method="POST">');

		e('<div class="tbl-menu">');
			if ($Us->Status->_access_level < 3) {
				$delButton = '<img class="img-btn" src="'. url('/img/delete.png') .'">';

				e('<button class="" name="deleteDocuments">'. $delButton .'</button>');
			}
		e('</div>');

		e('<div class="tbl-header">');
			e('<span class="tbl-th h-num">№</span>');
			e('<span class="tbl-th h-title">Назва</span>');
			e('<span class="tbl-th h-date">Дата документа</span>');
			e('<span class="tbl-th h-d_num">№ документа</span>');
			e('<span class="tbl-th h-executon_user">Призначений виконавець</span>');
		e('</div>');

		$num = $d['Pagin']->getCurrentPageFirstItem();

		e('<div class="tbl-body">');

			foreach ($d['documents'] as $docRow) {
				e('<div class="tbl-tr">');
					$Doc = new internal_documents_registry(null, $docRow);
					$docCardURL = url('/df/documents-internal/card', ['n' => $Doc->_number]);

					$executionIMG = '';
					$anchorLink = '';

					if ($Doc->_execution_date) {
						$execDt = date('d.m.Y', strtotime($Doc->_execution_date));

						$executionIMG = '<img class="" src="'. URLHome .'/img/button_active.png">';

						$anchorLink = '<a class="img-btn" title="Виконано: '. $execDt .
							'" href="'. $docCardURL .'#dExecutionDateAnchor">'. $executionIMG .'</a>';
					}

					$docTitle = '<a href="'. $docCardURL .'" target="_blank" title="Картка документа">'.
						$Doc->DocumentTitle->_title .'</a>'. $anchorLink;

					$delCheckbox = '<span class="del-checkbox"><input type="checkbox" name="docsId[]" value="'.
						$Doc->_id .'" title="Помітити для видалення"></span>';

					e('<span class="tbl-td d_title"><span class="num">'. $num++ .'.</span>'.
						$delCheckbox . $docTitle .'</span>');

					e('<span class="tbl-td d_date" title="Дата документа">'.
						date('d.m.Y', strtotime($Doc->_document_date)) .'</span>');

					require $this->getViewFile('inc/initDocNumData');

					e('<span '. $docNumStyle .' class="tbl-td doc_num" title="'. $docNumTitle .'">' .
						strtoupper($Doc->displayedNumber) .'</span>');

					require $this->getViewFile('inc/initExecutionData');

					if ($Doc->ExecutorUser) {
						$executorLogin = $Doc->ExecutorUser->_login;

						$executorLogin = '<a '. $executionLoginStyle .' href="'.
							url('/user/profile?l='. $executorLogin) .'">'. $executorLogin .'</a>';
					}
					else {
						$executorLogin = ' - ';
					}

					if ($executionStyle) $executionStyle = ' '. $executionStyle .' ';

					e('<span class="tbl-td d_executor" '. $executionTitle .' '. $executionStyle .'>'.
						$executorLogin .'</span>');

				e('</div>');
			}

		e('</div>');

	e('</form>');
}

require $this->getViewFile('/inc/footer');
