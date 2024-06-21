<?php

// Ініціалізація стилю та атрибуту title для виводу логіна виконавця користувача.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$executionStyle = '';
$executionTitle = '';
$executionLoginStyle = '';
$executorLogin = '';

$controlDate = $Doc->_control_date ? date('d.m.Y', strtotime($Doc->_control_date)) : null;

if ($controlDate) $executionTitle .= "Термін виконання ". $controlDate .";\n";
else $executionTitle .= "Термін виконання не визначений;\n";

if ($Doc->isDueDateOverdue) {
	// Дата виконання документа прострочена.

	$executionStyle .= 'border:2px solid red;border-radius:7px;';
	$executionLoginStyle .= 'color:red;';
	$executionTitle .= "Дата виконання прострочена;\n";
}

if (($Doc->isOverdue === 1) && $Doc->remindAboutDueDate) {
	$executionStyle .= 'border:2px solid red;border-radius:7px;';
	$executionLoginStyle .= '';
}
else if (($Doc->isOverdue === 1) && ! $Doc->remindAboutDueDate) {
	$executionStyle .= 'border:2px solid #0eff0e;border-radius:7px;';
	$executionLoginStyle .= '';
}

if ($Doc->_id_execution_control && $Doc->NextControlDate) {
	$dt = $Doc->NextControlDate->format('d.m.Y');

	if ($dt === date('d.m.Y')) $s = 'сьогодні';
	else $s = $dt;

	$executionTitle .= "Чергова дата контроля: ". $s .";\n";
}

if ($executionLoginStyle) $executionLoginStyle = ' style="'. trim($executionLoginStyle, ";\n") .'"';

if ($Doc->ExecutorUser->_id) {
	$executorLogin = $Doc->ExecutorUser->_login;

	$executorLogin = '<a '. $executionLoginStyle .' href="'.
		url('/user/profile?l='. $executorLogin) .'">'. $executorLogin .'</a>';
}

if (! $executorLogin) $executorLogin = ' - ';

if ($executionStyle) $executionStyle = 'style="'. trim($executionStyle, ";\n") .'"';

if ($executionTitle) $executionTitle = 'title="'. trim($executionTitle, ";\n") .'"';
