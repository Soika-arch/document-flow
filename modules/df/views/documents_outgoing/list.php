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

	e('<form name="doc_list" class="tbl doc_list" action="'.
		url('/df/documents-outgoing/list') .'" method="POST">');

		e('<div class="tbl-menu">');
			if ($Us->Status->_access_level < 3) {
				$delButton = '<img class="img-btn" src="'. url('/img/delete.png') .'">';

				e('<button name="deleteDocuments">'. $delButton .'</button>');
			}
		e('</div>');

		e('<div class="tbl-header">');
			e('<span class="tbl-th h-num">№</span>');
			e('<span class="tbl-th h-title">Назва</span>');
			e('<span class="tbl-th h-date">Дата документа</span>');
			e('<span class="tbl-th h-d_num">№ документа</span>');
			e('<span class="tbl-th h-executon_user">Призначений виконавець</span>');
			e('<span class="tbl-th h-resolution">Резолюція</span>');
		e('</div>');

		$num = $d['Pagin']->getCurrentPageFirstItem();

		e('<div class="tbl-body">');

			foreach ($d['documents'] as $docRow) {
				e('<div class="tbl-tr">');
					$Doc = new outgoing_documents_registry(null, $docRow);
					$docCardURL = url('/df/documents-outgoing/card', ['n' => $Doc->_number]);

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

					e('<span class="tbl-td d_title"><span class="num">'. $num++ .'</span>'.
						$delCheckbox . $docTitle .'</span>');

					e('<span class="tbl-td d_date" title="Дата документа">'.
						date('d.m.Y', strtotime($Doc->_document_date)) .'</span>');

					if ($Doc->_date_of_receipt_by_executor) {
						$isReceivedStyle = 'border:solid 2px #0eff0e;border-radius:7px;';
						$docNumTitle = "Отримано виконавцем;\n";
					}
					else {
						$isReceivedStyle = 'border:solid 2px red;border-radius:7px;';
						$docNumTitle = "Не отримано виконавцем;\n";
					}

					if ($isReceivedStyle) $isReceivedStyle = ' style="'. $isReceivedStyle .'"';

					e('<span '. $isReceivedStyle .' class="tbl-td doc_num" title="'. $docNumTitle .'">' .
						strtoupper($Doc->displayedNumber) .'</span>');

					// ($Doc->_number === '00000003')

					if ($Doc->isOverdue === 2) {
						// Дата виконання документа прострочена.

						$isExecutionStyle = 'border:2px solid red;border-radius:7px;';
						$isExecutionLoginStyle = 'color:red;';
						$executionTitle = "Дата виконання прострочена;\n";
						$isExecutionLoginStyle = 'color:red;';
					}
					else if (($Doc->isOverdue === 1) && $Doc->remindAboutDueDate) {
						$isExecutionStyle = 'border:2px solid red;border-radius:7px;';
						$dt = date('d.m.Y', strtotime($Doc->_control_date));
						$executionTitle = "Термін виконання ". $dt .";\n";
						$isExecutionLoginStyle = '';
					}
					else if (($Doc->isOverdue === 1) && ! $Doc->remindAboutDueDate) {
						$isExecutionStyle = 'border:2px solid #0eff0e;border-radius:7px;';
						$dt = date('d.m.Y', strtotime($Doc->_control_date));
						$executionTitle = "Термін виконання ". $dt .";\n";
						$isExecutionLoginStyle = '';
					}
					else {
						$isExecutionStyle = 'border:2px solid #0eff0e;border-radius:7px;';
						$isExecutionLoginStyle = '';

						if ($Doc->isOverdue === 1) {
							$dt = date('d.m.Y', strtotime($Doc->_control_date));
							$executionTitle = "Термін виконання ". $dt .";\n";
						}
						else {
							$executionTitle = "Термін виконання не визначений;\n";
						}
					}

					if ($Doc->_number === '00000006') {
						// dd([$Doc->_id_execution_control && $Doc->NextControlDate], __FILE__, __LINE__,1);
					}

					if ($Doc->_id_execution_control && $Doc->NextControlDate) {
						$dt = $Doc->NextControlDate->format('d.m.Y');

						if ($dt === date('d.m.Y')) $s = 'сьогодні';
						else $s = $dt;

						$executionTitle .= "Чергова дата контроля: ". $s .";\n";
					}

					if ($isExecutionLoginStyle) {
						$isExecutionLoginStyle = ' style="'. $isExecutionLoginStyle .'"';
					}

					if ($Doc->ExecutorUser) {
						$executorLogin = $Doc->ExecutorUser->_login;

						$executorLogin = '<a '. $isExecutionLoginStyle .' href="'.
							url('/user/profile?l='. $executorLogin) .'">'. $executorLogin .'</a>';
					}
					else {
						$executorLogin = '';
					}

					if ($isExecutionStyle) $isExecutionStyle = ' style="'. $isExecutionStyle .'"';

					e('<span class="tbl-td d_executor" title="'. $executionTitle .'"'. $isExecutionStyle .'>'.
						$executorLogin .'</span>');

				e('</div>');
			}

		e('</div>');

	e('</form>');
}

require $this->getViewFile('/inc/footer');
