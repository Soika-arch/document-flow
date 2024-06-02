<?php

// Меню користувача 1.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

e('<div class="user-menu-1">');

	if ($Us->Status->_access_level < 5) {
		if ($c = $Us->getUnreadMessagesCount()) {
			$msgLink = '<a href="'. url('/messages') .'"><img class="img-button" src="'.
				url('/img/email2.jpg') .'" title="'. $c .' непрочитаних повідомлень"></a>';
		}
		else {
			$msgLink = '<a href="'. url('/messages') .'"><img class="img-button" src="'.
				url('/img/email1.jpg') .'" title="Повідомлення"></a>';
		}

		e('<div>');
			e($msgLink);
		e('</div>');
	}

	e('<div>');
		e('<a href="'. url('/user/profile?l='. $Us->_login) .'">'. $Us->_login .'</a>');
	e('</div>');

e('</div>');
