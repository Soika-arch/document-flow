<?php

// Функції роботи з часом та датами.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * @return \DateTime
 */
function tm_getDatetime (string $dt='') {

	return new \DateTime($dt);
}

/**
 * Перетворює заданий рядок дати у вказаний формат, додаючи поточний час, якщо він не вказаний.
 * Ця функція приймає рядок дати та рядок формату, перевіряє, чи містить рядок дати час.
 * Якщо час не вказаний, додає поточний час. Потім перетворює рядок дати у об'єкт DateTime
 * і форматує його згідно з вказаним форматом.
 * @param string $dt Рядок дати для перетворення. За замовчуванням порожній рядок.
 * @param string $format Формат, у якому повертається рядок дати. За замовчуванням 'Y-m-d H:i:s'.
 * @return string Форматований рядок дати.
 */
function tm_convertToDatetime (string $dt='', string $format='Y-m-d H:i:s') {
	if (! preg_match('/ \d\d:\d\d:\d\d/', $dt, $m)) $dt = trim($dt) .' '. date('H:i:s', time());

	return tm_getDatetime($dt)->format($format);
}
