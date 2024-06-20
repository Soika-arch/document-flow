<?php

namespace core\models;

/**
 * Базова модель.
 */
class MainModel {

	use \core\traits\SetGet;

	/**
	 *
	 */
	public function __construct () {}

	/**
	 * Повертає дані для сторінки ''.
	 * @return array
	 */
	public function confirmationPage () {
		$d['title'] = 'Підтвердження операції';

		return $d;
	}

	/**
	 * Повертає дані для сторінки ''.
	 * @return array
	 */
	public function mainPage () {
		$d['title'] = 'Авторизація користувача';

		return $d;
	}

	/**
	 * Отримання записів БД по значенню вказаного стовпця.
	 * @param string $from назва таблиці запиту.
	 * @param string $colName назва стовпця за яким буде здійснено пошук запису.
	 * @param string $colValue значення стовпця $colName за яким буде здійснено пошук запису.
	 * @param array $columns запитувані стовпці таблиці.
	 * @param string $operator оператор за яким буде виконуватись порівняння $colName з $colValue.
	 * @param bool $exec якщо false - запит здійснено не буде, а буде повернено об'єкт SelectQuery.
	 * @return array|\libs\query_builder\SelectQuery
	 */
	public function selectRowsByCol (string $from, string $colName='', mixed $colValue='', array $columns=['*'], string $operator='=', bool $exec=true) {
		$SQL = db_getSelect();

		$SQL->columns($columns)->from($from);

		if ($colName) $SQL->columns($columns)->from($from)->where($colName, $operator, $colValue);

		return $exec ? db_select($SQL) : $SQL;
	}

	/**
	 * Отримання запису БД по значенню вказаного стовпця.
	 * @param string $from назва таблиці запиту.
	 * @param string $colName назва стовпця за яким буде здійснено пошук запису.
	 * @param string $colValue значення стовпця $colName за яким буде здійснено пошук запису.
	 * @param array $columns запитувані стовпці таблиці.
	 * @param string $operator оператор за яким буде виконуватись порівняння $colName з $colValue.
	 * @param bool $exec якщо false - запит здійснено не буде, а буде повернено об'єкт SelectQuery.
	 * @return array|\libs\query_builder\SelectQuery
	 */
	public function selectRowByCol (string $from, string $colName, mixed $colValue, array $columns=['*'], string $operator='=', bool $exec=true) {
		$SQL = db_getSelect();

		$SQL->columns($columns)->from($from)->where($colName, $operator, $colValue);

		return $exec ? db_selectRow($SQL) : $SQL;
	}

	/**
	 * Отримання значення вказаного поля таблиці БД по значенню вказаного стовпця.
	 * Опис параметрів дивитись у методі self::selectRowByCol.
	 * @return string|int|\libs\query_builder\SelectQuery
	 */
	public function selectCellByCol (string $from, string $colName, mixed $colValue, string $column, string $operator='=', bool $exec=true) {
		$SQL = $this->selectRowByCol($from, $colName, $colValue, [$column], $operator, false);

		return $exec ? db_selectCell($SQL) : $SQL;
	}
}
