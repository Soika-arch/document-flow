<?php

// Вид головної сторінки повідомлень користувача.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="user-messages">');

	if ($d['messages']) {
		if (isset($d['Pagin']) && ($d['Pagin']->getNumPages() > 1)) {
			$htmlPagin = $d['Pagin']->toHtml();
			e($htmlPagin);
		}

		$num = $d['Pagin']->getCurrentPageFirstItem();

		e('<form name="user_messages" action="'. url('/messages/delete') .'#pagin" method="POST">');

			e('<div class="fm-menu">');
				$delButton = '<img class="img-button" src="'. url('/img/delete.png') .'">';

				e('<button class="fm-menu-elem" name="deleteMessages">'. $delButton .'</button>');
			e('</div>');

			foreach ($d['messages'] as $msgRow) {
				$msgLink = '<a href="'. url('/messages/viewing?m='. $msgRow['usm_id']) .'">'.
					$msgRow['usm_header'] .'</a>';

				e('<div class="message">');
					e('<span class="header-num">'. $num++ .'. </span>');
					e('<input type="checkbox" name="msgsId[]" value="'. $msgRow['usm_id'] .'">');
					e('<span class="header-title">'. $msgLink .'. </span>');
				e('</div>');
			}

		e('</form>');
	}

	if (isset($htmlPagin)) e($htmlPagin);

e('</div>');

require $this->getViewFile('/inc/footer');
