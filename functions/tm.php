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
	if (! $dt) $dt = date('Y-m-d H:i:s');

	if (! preg_match('/ \d\d:\d\d:\d\d/', $dt, $m)) $dt = trim($dt) .' '. date('H:i:s', time());

	return tm_getDatetime($dt)->format($format);
}

/**
 * Обчислює різницю між двома датами у вказаному форматі.
 *
 * @param string $dtMax Максимальна дата в форматі 'Y-m-d H:i:s'.
 * @param string $dtMin Мінімальна дата в форматі 'Y-m-d H:i:s'.
 * @param string $value Одиниця виміру різниці. Може бути одним з властивостей об'єкта DateInterval,
 *  таких як 'y', 'm', 'd', 'h', 'i', 's', 'days'. За замовчуванням 'days'.
 * @return int Різниця між датами у вказаній одиниці виміру.
 * @throws \Exception Якщо формат дати неправильний або якщо вказано невірний параметр.
 */
function tm_getDiff (string $dtMax, string $dtMin, string $value = 'days'): int {
  // Перелік допустимих значень для параметра $value
  $validValues = ['y', 'm', 'd', 'h', 'i', 's', 'days'];

  // Перевірка, чи є $value допустимим
  if (!in_array($value, $validValues)) {
    throw new \InvalidArgumentException("Недопустиме значення для параметра 'value': $value");
  }

  // Створення об'єктів DateTime для обох дат
  $dateMax = new \DateTime($dtMax);
  $dateMin = new \DateTime($dtMin);

  // Отримання різниці між датами як об'єкт DateInterval
  $interval = $dateMax->diff($dateMin);
	$result = $interval->$value;

  // Повернення значення різниці у вказаній одиниці виміру
  return ($dateMax > $dateMin) ? $result : -$result;
}
