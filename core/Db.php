<?php

namespace core;

use libs\query_builder\Connection;
use libs\query_builder\InsertQuery;
use libs\query_builder\SelectQuery;
use libs\query_builder\UpdateQuery;

/**
 * Клас взаємодії з базою MySQL.
 */
class Db {

	use traits\Singleton_SetGet;

	/** [1] Свойства и константы. */

	private \PDO $PDO;
	private Connection $Connection;
  // Если true, то будет сгенерировано исключение и выведен текущий sql-запрос.
  // Для установки в true: Db::$d = true.
  public bool $d = false;
	// Массив данных `information_schema` таблиц текущей БД.
	private array $tables;
	// Масив згенерованих даних `information_schema` таблиць поточної БД.
	private array $tblData;
	private int $queriesCounter;
	private array $nSqlLogs = [];
	private array $sqlLogs = [];
	// Масив стовпців таблиць БД ['tbl_1' => ['col_name_1', 'col_name_2', ...], ...].
	private array $tableColumns;

	/** [1] Магические методы. */

	/** [1] Сеттеры свойств. */

	/** [1] Геттеры свойств. */

	/**
	 *
	 */
	private function get_PDO () {

		return $this->PDO;
	}

	/**
	 * @return libs\query_builder\Connection
	 */
	private function get_Connection () {

		return $this->Connection;
	}

	/**
	 *
	 */
	private function get_tables () {

		return $this->tables;
	}

	/**
	 *
	 */
	private function get_tblData () {

		return $this->tblData;
	}

	/**
	 *
	 */
	private function get_queries () {

		return $this->queries;
	}

	/**
	 *
	 */
	private function get_queriesCounter () {

		return $this->queriesCounter;
	}

	/**
	 *
	 */
	private function get_sqlLogs () {

		return $this->sqlLogs;
	}

	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/**
   * Вместо __construct() этот метод позволяет инициализировать данные класса и объекта.
   * Автоматически вызывается в $this->instance() только при создании текущего Singleton объекта.
   */
  private function _init () {
		$this->PDO = new \PDO('mysql:host='. DbHost .';dbname='. DbName, DbUser, DbPass);
		$this->Connection = new Connection($this->PDO);
		$this->queriesCounter = 0;

		$Select = db_getSelect();

		$Select
			->from('information_schema.TABLES')
			->columns(['*'])
			->where('TABLES.TABLE_SCHEMA', '=', DbName)
			->where($Select->raw('LEFT(TABLES.TABLE_NAME, 3) = "'. DbPrefix .'"'));

		$tblInfo = db_select($Select);

		for ($i = 0; $i < count($tblInfo); $i++) {
			$tName = $tblInfo[$i]['TABLE_NAME'];

			$this->tables[$tName] = $tblInfo[$i];
			$this->tblData[$tName] = [];
			$this->tblData[$tName]['cols'] = [];
		}
  }

	/**
	 * @return InsertQuery
	 */
	public function getInsert () {

		return $this->Connection->insert();
	}

	/**
	 * @return SelectQuery
	 */
	public function getSelect () {

		return $this->Connection->select();
	}

	/**
	 * @return UpdateQuery
	 */
	public function getUpdate () {

		return $this->Connection->update();
	}

	/**
	 * Для отримання рядків.
	 * @return array
	 */
	public function select (SelectQuery $SQL, $mode=\PDO::FETCH_ASSOC) {
		if (LogSql) $this->logger($SQL->prepare());

		$this->queriesCounter++;

		return $SQL->execute()->fetchAll($mode);
	}

	/**
	 * Оновлення записів таблиць БД.
	 * @return array
	 */
	public function update (UpdateQuery $SQL) {
		$Sth = $SQL->prepare();

		if (LogSql) $this->logger($Sth);

		$this->queriesCounter++;

		return ['result' => $Sth->execute(), 'affectedRowCount' => $Sth->rowCount()];
	}

	/**
	 * Вставка одного рядка в таблицю.
	 * @return array
	 */
	public function insertRow (InsertQuery $SQL) {
		if (LogSql) $this->logger($SQL->prepare());

		$this->queriesCounter++;

		return ['result' => $SQL->execute(), 'lastInsertId' => $SQL->lastInsertId()];
	}

	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

  /**
   * Логування успішних SQL-запитів.
   */
  private function logger (object $Sth) {
		if (LogSql) $this->sqlLogs[] = $Sth->queryString;
  }

	/**
	 * Отримання префікса стовпців вказаної таблиці.
	 * @return string|null
	 */
	public function getColPxByTableName (string $tName) {
		if (! isset($this->tblData[$tName]['colPx'])) {
			// Отримання даних стовпців таблиці $tName із таблиці information_schema.COLUMNS.
			$this->getTableColumns($tName);

			foreach ($this->tblData[$tName]['columns'] as $colName => $colData) {
				// Префікс стовпців береться зі стовпці px_id.
				$pos = (strpos($colName, '_id') === (strlen($colName) - 3));

				if (($pos = strpos($colName, '_id')) !== false) {
					$this->tblData[$tName]['colPx'] = substr($colName, 0, ($pos + 1));
				}
			}
		}

		return $this->tblData[$tName]['colPx'];
	}

	/**
	 * Получение полного имени таблицы с именем БД и в обратных кавычках.
	 */
	public function getFullTableName (string $tName) {
		if (! isset($this->tblData[$tName]['fullTableName'])) {
			$this->tblData[$tName]['fullTableName'] = "`{$this->tables[$tName]['TABLE_NAME']}`";
		}

		return $this->tblData[$tName]['fullTableName'];
	}

	/**
	 * Получение полного имени столбца с именем БД и в обратных кавычках.
	 */
	public function getFullColName (string $tName, string $colName) {
		if (! isset($this->tblData[$tName]['cols'][$colName]['fullName'])) {
			if (! isset($this->tblData[$tName]['cols'][$colName])) {
				$this->tblData[$tName]['cols'][$colName] = [];
			}

			$this->tblData[$tName]['cols'][$colName]['fullName'] = '`'. $tName .'`.`'. $colName .'`';
		}

		return $this->tblData[$tName]['cols'][$colName]['fullName'];
	}

	/**
	 * Отримання стовпців вказаної таблиці.
	 */
	public function getTableColumns (string $tName) {
		if (! isset($this->tblData[$tName]['columns'])) {
			$SQL = db_getSelect();

			$SQL
				->columns(['*'])
				->from('information_schema.COLUMNS')
				->where('COLUMNS.TABLE_SCHEMA', '=', DbName)
				->where('COLUMNS.TABLE_NAME', '=', $tName)
				->orderBy('COLUMNS.ORDINAL_POSITION');

			$colsInfo = db_select($SQL);

			$this->tblData[$tName]['columns'] = [];

			for ($i = 0; $i < count($colsInfo); $i++) {
				$this->tblData[$tName]['columns'][$colsInfo[$i]['COLUMN_NAME']] = $colsInfo[$i];
			}
		}

		return $this->tblData[$tName]['columns'];
	}

	/**
	 *
	 */
	public function getTableInfo (string $tName) {
		if (! isset($this->tblData[$tName]['fullColsStr'])) {

			if (! isset($this->tblData[$tName]['cols'])) $this->getTableColumns($tName);

			$fullColsStr = '';

			for ($i = 0; $i < count($this->tblData[$tName]['cols']); $i++) {
				$fullColsStr .= '`'. $tName .'`.`'. $this->tblData[$tName]['cols'][$i] .'`, ';
			}

			$this->tblData[$tName]['fullColsStr'] = trim($fullColsStr, ', ');
		}

		return $this->tblData[$tName]['fullColsStr'];
	}

	/**
	 * Перевірка наявності відповідного поля у відповідній таблиці.
	 * @return bool
	 */
	public function isTableColumn (string $tName, string $colName) {
		if (! isset($this->tblData[$tName]['columns'][$colName])) $this->getTableInfo($tName);

		return isset($this->tblData[$tName]['columns'][$colName]);
	}
}
