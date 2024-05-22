<?php

// Функції взаємодії з масивом $_SESSION.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Додавання нового повідомлення в масив $_SESSION['sysMessages'].
 */
function sess_addSysMessage (string $msg) {
	$_SESSION['sysMessages'][] = $msg;
}

/**
 * Перевірка наявності sysMessages повідомленнь.
 * @return bool
 */
function sess_isSysMessages () {

	return (isset($_SESSION['sysMessages']) && $_SESSION['sysMessages']);
}

/**
 * Додавання нового повідомлення в масив $_SESSION['errors'].
 */
function sess_addErrMessage (string $msg) {
	$_SESSION['errors'][] = $msg;
}

/**
 * Перевірка наявності errors повідомленнь.
 * @return bool
 */
function sess_isErrMessages () {

	return (isset($_SESSION['errors']) && $_SESSION['errors']);
}

/**
 * Додавання повідомлення в масиві $_SESSION['sysMessages'].
 */
function sess_deleteSysMessage (int $key) {
	if (isset($_SESSION['sysMessages'][$key])) unset($_SESSION['sysMessages'][$key]);
}

/**
 * Додавання даних підтвердження операції користувача в масив $_SESSION['confirmation'].
 */
function sess_addConfirmData (array $data) {
	$_SESSION['confirmation'] = $data;
}
