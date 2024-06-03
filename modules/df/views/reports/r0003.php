<?php

// Звіт по виконавцім, які не виконали документи.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use \core\User;

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');
require $this->getViewFile('inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

require $this->getViewFile('inc/menu/menu_journal_1');

if (isset($d['users']) && $d['users']) {
	if ($d['Pagin']->getNumPages() > 1) e($d['Pagin']->toHtml());

	e('<div class="user-list">');

		e('<div class="doc-header">');
			e('<span class="header-num">№</span>');
			e('<span class="header-title">Логін</span>');
		e('</div>');

		$num = $d['Pagin']->getCurrentPageFirstItem();

		foreach ($d['users'] as $docRow) {
			$UsTemp = new User(null, $docRow);

			$docCardURL = url('/user/profile?l=', ['l' => $UsTemp->_login]);

			$profileLink = '<a href="'. $docCardURL .'" target="_blank" title="Профіль користувача">'.
				$UsTemp->_login .'</a>';

			e('<div class="user-block">');
				e('<span>'. $num++ .'</span>');
				e('<span>'. $profileLink .'</span>');
				e('<span>[ '. count($UsTemp->notExecutionIncomingDocuments) .' ]</span>');
			e('</div>');
		}

	e('</div>');
}

require $this->getViewFile('/inc/footer');
