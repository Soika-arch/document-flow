<?php

namespace core;

use libs\query_builder\Connection;

/**
 * Клас взаємодії з базою MySQL.
 */
class Db {

	use traits\Singleton;
	use traits\Singleton_SetGet;

	/** [1] Свойства и константы. */

	private Connection $Connection;
  // Если true, то будет сгенерировано исключение и выведен текущий sql-запрос.
  // Для установки в true: Db::$d = true.
  public bool $d = false;
  // Префиксы таблиц БД.
  private string $tblPrefix;
	// Массив данных `information_schema` таблиц текущей БД.
	private array $tables;
	// Массив сгенерированных данных `information_schema` таблиц текущей БД.
	private array $tblData;
	private int $requestCounter;
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
	private function get_tblPrefix () {

		return $this->tblPrefix;
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
	private function get_requestCounter () {

		return $this->requestCounter;
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
		$PDO = new \PDO('mysql:host='. DbHost .';dbname='. DbName, DbUser, DbPass);
		$this->Connection = new Connection($PDO);
		$this->requestCounter = 0;

		$Select = $this->getSelect();

		$Select
			->from('information_schema.TABLES')
			->columns(['*'])
			->where('TABLES.TABLE_SCHEMA', '=', DbName)
			->where($Select->raw('LEFT(TABLES.TABLE_NAME, 3) = "df_"'));

		$tblInfo = $Select->execute()->fetchAll($PDO::FETCH_ASSOC);

		for ($i = 0; $i < count($tblInfo); $i++) {
			$tName = $tblInfo[$i]['TABLE_NAME'];

			$this->tables[$tName] = $tblInfo[$i];
			$this->tblData[$tName] = [];
			$this->tblData[$tName]['cols'] = [];
		}
  }

	/**
	 * @return libs\query_builder\SelectQuery
	 */
	public function getSelect () {

		return $this->Connection->select();
	}

	/**
	 * @return
	 */
	public function getTblPx (string $tName) {
		dd('', __FILE__, __LINE__,1);
		if (! isset($this->tblData[$tName]['px'])) {
			dd($this->tblData[$tName], __FILE__, __LINE__,1);
			// $this->tblData[$tName]['px'] =
		}
	}

	/**
	 *
	 */
	private function debug (string $qId, bool $d=false) {
		if ($d)
			err("classes.Db", 2, __FILE__, __LINE__, debug_backtrace(),
				['sql' => $this->queries[$qId]->prepare()->queryString]);
	}

	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

  /**
   * Логирование успешных sql-запросов.
   */
  private function logger (object $sth) {
		if (Debug) {
			$this->sqlLogs[] = $sth->prepare()->queryString;
		}
  }

	/**
	 * Отримання префікса стовпців вказаної таблиці.
	 */
	public function getColPx (string $tName) {
		if (! isset($this->tblData[$tName]['colPx'])) $this->getTableColumns($tName);

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
	 *
	 */
	public function getTableColumns (string $tName) {
		if (! isset($this->tblData[$tName]['COLUMNS'])) {
			$sql = 'SELECT * FROM `information_schema`.`COLUMNS` WHERE `COLUMNS`.`TABLE_SCHEMA` = "'.
				DB_NAME .'" AND `COLUMNS`.`TABLE_NAME` = "'. $tName .'" ORDER BY '.
				'`COLUMNS`.`ORDINAL_POSITION`';

			$colsInfo = db_select($sql);

			$this->tblData[$tName]['COLUMNS'] = [];

			if (isset($colsInfo[0])) {
				$pos = strpos($colsInfo[0]['COLUMN_NAME'], '_');

				$this->tblData[$tName]['colPx'] = $pos ?
					substr($colsInfo[0]['COLUMN_NAME'], 0, ($pos + 1)) : '';
			}

			for ($i = 0; $i < count($colsInfo); $i++) {
				$this->tblData[$tName]['COLUMNS'][$colsInfo[$i]['COLUMN_NAME']] = $colsInfo[$i];
			}
		}

		return $this->tblData[$tName]['COLUMNS'];
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
		if (! isset($this->tblData[$tName]['COLUMNS'][$colName])) $this->getTableInfo($tName);

		return isset($this->tblData[$tName]['COLUMNS'][$colName]);
	}
}
