<?php

// Вид головної типів документів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div>');

	e('<div>');
		$url = url('/df');

		e('<div class="menu-journal-1">');
			e('<span class="elem"><a href="'. $url .'?mode=inc">Вхідні</a></span>');
			e('<span class="elem"><a href="'. $url .'?mode=out">Вихідні</a></span>');
			e('<span class="elem"><a href="'. $url .'?mode=int">Внутрішні</a></span>');
		e('</div>');
	e('</div>');

	e('<div>');

		if ($d['documents']) {
			e('<div class="document-journal">');
				if ($d['Pagin']->getNumPages() > 1) e($d['Pagin']->toHtml());

				$num = $d['Pagin']->getCurrentPageFirstItem();

				foreach ($d['documents'] as $docRow) {
					e('<div>');
						$className = '\core\db_record\\'. $d['tableName'];
						$Doc = new $className($docRow[$d['px'] .'id'], $docRow);

						$docCardURL = url('/df/documents-incoming/card',
							['n' => str_replace('inc_', '', $Doc->_number)]);

						$docTitle = '<a href="'. $docCardURL .'" target="_blank">'.
							$Doc->DocumentTitle->_title .'</a>';

						e('<div>');
							e('<span>'. $num++ .'.</span>');
							e('<span>'. $docTitle .'</span>');
							e('<span class="doc-date">'. date('d.m.Y', strtotime($Doc->_document_date)) .'</span>');
							e('<span class="doc-date">'. strtoupper($Doc->_number) .'</span>');
						e('</div>');
					e('</div>');
				}
			e('</div>');
		}

	e('</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
