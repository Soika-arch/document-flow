<?php

// Функції взаємодії з БД.

use core\Db;
use core\exceptions\DbException;

/**
 *
 */
function db_queryDump (string $sql, array $binds=[]) {
	$dumpData = [];
	$Pdo = Db::getInstance()->dbh;
	$Pdo->beginTransaction();
	$Sth = $Pdo->prepare($sql);
	ob_start();
	$Sth->execute($binds);
  $Sth->debugDumpParams();
  $sqlDump = ob_get_contents();
	$sqlDump = str_replace("\n", ' ', $sqlDump);
	preg_match('#^(.*?\] )(.*?) Sent SQL#', $sqlDump, $m);
	$dumpData['sql2'] = trim($m[2]);
	preg_match('#(Sent SQL:.*?\] )(.*?) Params:#', $sqlDump, $m);
	$dumpData['sentSql'] = trim($m[2]);
	preg_match('#Params:.*$#', $sqlDump, $m);
	$dumpData['params'] = trim($m[0]);
	$dumpData['Sth'] = $Sth;
  ob_end_clean();
	dd([$dumpData, debug_backtrace()], __FILE__, __LINE__);
	$Pdo->rollBack();
	exit();
}

/**
 * @return \core\Db
 */
function db_Db () {

	return Db::getInstance();
}

/**
 * @return libs\query_builder\SelectQuery
 */
function db_getSelect () {

	return db_Db()->getSelect();
}

/**
 * @return libs\query_builder\InsertQuery
 */
function db_getInsert () {

	return db_Db()->getInsert();
}

/**
 * @return libs\query_builder\UpdateQuery
 */
function db_getUpdate () {

	return db_Db()->getUpdate();
}

/**
 * @return array
 */
function db_update (libs\query_builder\UpdateQuery $SQL) {

	return db_Db()->update($SQL);
}

/**
 * Для отримання рядків.
 * @return array
 */
function db_select (libs\query_builder\SelectQuery $SQL, $mode=\PDO::FETCH_ASSOC) {

	return db_Db()->select($SQL, $mode);
}

/**
 * Для отримання рядка.
 * @return array
 */
function db_selectRow (libs\query_builder\SelectQuery $SQL, $mode=\PDO::FETCH_ASSOC) {
	$row = db_select($SQL, $mode);

	if (count($row) <= 1) return isset($row[0]) ? $row[0] : [];

	throw new DbException(5000, [
		'sql' => $SQL->execute()->queryString,
		'Select' => $SQL,
		'rows' => $row
	]);
}

/**
 * Для отримання клітинки рядка.
 */
function db_selectCell (libs\query_builder\SelectQuery $SQL) {
	$row = db_selectRow($SQL, \PDO::FETCH_NUM);

	// Якщо відповідне значення не знайдено - повертається false.
	return isset($row[0]) ? $row[0] : false;
}

/**
 * Вставка одного рядка в таблицю.
 * @return array
 */
function db_insertRow (libs\query_builder\InsertQuery $SQL) {

	return db_Db()->insertRow($SQL);
}

/**
 * @return libs\query_builder\DeleteQuery
 */
function db_getDelete () {

	return db_Db()->delete();
}

/**
 * Отримання префікса стовпців стовпців таблиці БД.
 * @param string $tName назва таблиці
 * @return string|null
 */
function db_getColumnsPrefix (string $tName) {

	return db_Db()->getColPxByTableName($tName);
}

/**
 * Перевіряє наявність стовпця таблиці БД.
 * @param string $tName назва таблиці
 * @param string $colName назва стовпця
 * @return bool
 */
function db_isTableColumn (string $tName, string $colName) {

	return db_Db()->isTableColumn($tName, $colName);
}
