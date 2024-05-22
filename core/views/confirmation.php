<?php

// Вид сторінки підтвердження операції користувача.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

$sourceURL = $_SESSION['confirmation']['sourceURL'];

foreach ($_SESSION['confirmation']['paramsForDeletion'] as $pName) {
	$cancelURL = delURLParam($sourceURL, $pName);
}

e('<div class="user-confirmation">');
	e('<h3>'. $_SESSION['confirmation']['question'] .'</h3>');

	e('<div class="buttons">');
		e('<div>');
			e('<a class="cancel" href="'. $cancelURL .'">Відмінити</a>');
		e('</div>');
		e('<div>');
			$confirmURL = addURLParam($sourceURL, 'confirm', 'y');
			e('<a class="confirm" href="'. $confirmURL .'">Підтвердити</a>');
		e('</div>');
	e('</div>');
e('</div>');

require $this->getViewFile('/inc/footer');
