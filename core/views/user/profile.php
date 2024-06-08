<?php

// Вид сторінки профіля користувача.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$Us = rg_Rg()->get('Us');

require $this->getViewFile('/inc/header');
require $this->getViewFile('/inc/menu/user_1');
require $this->getViewFile('/inc/menu/main');

if (sess_isSysMessages()) require $this->getViewFile('/inc/sys_messages');
if (sess_isErrMessages()) require $this->getViewFile('/inc/errors');

e('<div class="user-profile">');

	e('<div class="item">');
		e('<span class="header-field">Користувач</span>');
		e('<span class="profile-data">'. $d['User']->_login .'</span>');
	e('</div>');

	e('<div class="item">');
		e('<span class="header-field">Останнє відвідування</span>');
		e('<span class="profile-data">'. $d['User']->getLastVisitTime($d['User']->_id) .'<span>');
	e('</div>');

	e('<div class="item">');
		e('<span class="header-field">Вхідні документи на виконанні</span>');
		e('<span class="profile-data">'. count($d['User']->notExecutionIncomingDocuments) .'<span>');
	e('</div>');

	e('<div class="item">');
		e('<span class="header-field">Внутрішні документи на виконанні</span>');
		e('<span class="profile-data">'. count($d['User']->notExecutionInternalDocuments) .'<span>');
	e('</div>');

	e('<div class="item">');
		e('<span class="header-field">Вхідні виконані документи</span>');
		e('<span class="profile-data">'. count($d['User']->executionIncomingDocuments) .'<span>');
	e('</div>');

	e('<div class="item">');
		e('<span class="header-field">Внутрішні виконані документи</span>');
		e('<span class="profile-data">'. count($d['User']->executionIncomingDocuments) .'<span>');
	e('</div>');

e('</div>');

require $this->getViewFile('/inc/footer');
