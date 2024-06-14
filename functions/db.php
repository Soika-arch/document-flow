<?php

// Функції взаємодії з БД.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

use \core\Db;
use \core\exceptions\DbException;

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
 * @return libs\query_builder\DeleteQuery
 */
function db_getDelete () {

	return db_Db()->getDelete();
}

/**
 * Для отримання рядків.
 * @return \Doctrine\DBAL\Query\QueryBuilder
 */
function db_DTSelect ($select=null) {

	return db_Db()->DTConnection->createQueryBuilder()->select($select);
}

/**
 * Для отримання рядків.
 * @return array
 */
function db_select (libs\query_builder\SelectQuery $SQL, $mode=\PDO::FETCH_ASSOC) {

	return db_Db()->select($SQL, $mode);
}

/**
 * Для отримання стовпця.
 * @return array
 */
function db_selectCol (libs\query_builder\SelectQuery $SQL, $mode=\PDO::FETCH_COLUMN) {

	return db_select($SQL, $mode);
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
 * @return array
 */
function db_update (libs\query_builder\UpdateQuery $SQL) {

	return db_Db()->update($SQL);
}

/**
 * Вставка одного рядка в таблицю.
 * @return array
 */
function db_insertRow (libs\query_builder\InsertQuery $SQL) {

	return db_Db()->insertRow($SQL);
}

/**
 * Видалення рядків.
 * @return array
 */
function db_delete (libs\query_builder\DeleteQuery $SQL) {

	return db_Db()->delete($SQL);
}

/**
 * Видалення рядка.
 * @return array
 */
function db_deleteRow (libs\query_builder\DeleteQuery $SQL) {
	$SQL->limit(1);

	return db_delete($SQL);
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
