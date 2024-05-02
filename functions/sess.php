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
 * Додавання повідомлення в масиві $_SESSION['sysMessages'].
 */
function sess_deleteSysMessage (int $key) {
	if (isset($_SESSION['sysMessages'][$key])) unset($_SESSION['sysMessages'][$key]);
}
