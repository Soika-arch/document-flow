<?php

namespace core;

use \core\exceptions\DbException;
use \Doctrine\DBAL\Configuration;
use \Doctrine\DBAL\DriverManager;
use \Doctrine\DBAL\ParameterType;
use \libs\query_builder\Connection;
use \libs\query_builder\DeleteQuery;
use \libs\query_builder\InsertQuery;
use \libs\query_builder\SelectQuery;
use \libs\query_builder\UpdateQuery;

/**
 * Клас взаємодії з базою MySQL.
 */
class Db {

	use traits\Singleton_SetGet;

	private \PDO $PDO;
	private \libs\query_builder\Connection $Connection;
	private \Doctrine\DBAL\Connection $DTConnection;
	private \Doctrine\DBAL\Configuration $DTConfig;
	// Масив даних `information_schema` таблиць поточної БД.
	private array $tables;
	// Масив згенерованих даних `information_schema` таблиць поточної БД.
	private array $tblData;
	private int $queriesCounter;
	private array $nSqlLogs = [];
	private array $sqlLogs = [];
	// Масив стовпців таблиць БД ['tbl_1' => ['col_name_1', 'col_name_2', ...], ...].
	private array $tableColumns;

	/**
	 * @return \Doctrine\DBAL\Configuration
	 */
	private function get_DTConfig () {
		if (! isset($this->DTConfig)) {
			$this->DTConfig = new Configuration();

			if (LogSql) {
				file_put_contents(DirRoot .'/service/sql_log.log', '');
				$this->DTConfig->setSQLLogger(new DebugSQLLogger());
			}
		}

		return $this->DTConfig;
	}

	/**
	 * @return \Doctrine\DBAL\Connection
	 */
	private function get_DTConnection () {
		if (! isset($this->DTConnection)) {
			$this->DTConnection = DriverManager::getConnection([
				'dbname' => DbName,
				'user' => DbUser,
				'password' => DbPass,
				'host' => DbHost,
				'driver' => 'pdo_mysql'
			], $this->get_DTConfig());
		}

		return $this->DTConnection;
	}

	/**
	 * @return \PDO
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

  private function _init () {
		$this->PDO = new \PDO('mysql:host='. DbHost .';dbname='. DbName, DbUser, DbPass);
		$this->Connection = new Connection($this->PDO);
		$this->queriesCounter = 0;

		$tblInfo = db_DTSelect('*')
			->from('information_schema.TABLES', 'T')
			->where('T.TABLE_SCHEMA = :tableSchema')
			->where('LEFT(T.TABLE_NAME, 3) = :prefix')
			->setParameter('tableSchema', DbName, ParameterType::STRING)
			->setParameter('prefix', DbPrefix, ParameterType::STRING)
			->executeQuery()
			->fetchAllAssociative();

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
	 * @return DeleteQuery
	 */
	public function getDelete () {

		return $this->Connection->delete();
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

	/**
	 * Видалення рядків.
	 * @return array
	 */
	public function delete (DeleteQuery $SQL) {
		$Sth = $SQL->prepare();

		if (LogSql) $this->logger($SQL->prepare());

		$this->queriesCounter++;

		// true, якщо запит успішний і false - навпаки.
		$res['result'] = $Sth->execute();
		// Кількість видалених рядків.
		$res['rowCount'] = $Sth->rowCount();

		return $res;
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
				// $pos = (strpos($colName, '_id') === (strlen($colName) - 3));

				if (($pos = strpos($colName, '_')) !== false) {
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
			$colsInfo = db_DTSelect('*')
				->from('information_schema.COLUMNS', 'CS')
				->where('CS.TABLE_SCHEMA = :dbName')
				->andWhere('CS.TABLE_NAME = :tableName')
				->orderBy('CS.ORDINAL_POSITION', 'ASC')
				->setParameter('dbName', DbName, ParameterType::STRING)
				->setParameter('tableName', $tName, ParameterType::STRING)
				->executeQuery()
				->fetchAllAssociative();

			if (! $colsInfo) throw new DbException(5002);

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
	 * ! Не працює на хостингу. Хостинг не зберігає дані в таблиці REFERENTIAL_CONSTRAINTS.
	 * Отримує інформацію про зв'язки таблиці у базі даних.
	 * @param string $tableName Ім'я таблиці, для якої потрібно отримати інформацію про зв'язки.
 	 * @param string $databaseName Назва бази даних. За замовчуванням використовується значення
	 * константи DbName.
 	 * @param string $relatedColumn Ім'я стовпця, який є зовнішнім ключем у пов'язаній таблиці.
	 * За замовчуванням 'id'.
	 * @return array Масив, що містить інформацію про зв'язки таблиці.
	 */
	public function getTableForeignKeys (string $tName, string $dbName=DbName, string $relatedColumn='id') {
		if (! isset($this->tblData[$tName]['foreignKeys'])) {
			// Отримуємо префікс первинного ключа для таблиці.
			$px = $this->getColPxByTableName($tName);

			// Формуємо повне ім'я стовпця посилання, якщо необхідно.
			$relatedColumn = ($relatedColumn === 'id') ? $px . $relatedColumn : $relatedColumn;

			// Підготовляємо SQL-запит для отримання інформації про зв'язки.
			$Sth = db_Db()->PDO->prepare('SELECT rc.CONSTRAINT_CATALOG AS RC_CONSTRAINT_CATALOG, rc.CONSTRAINT_SCHEMA AS RC_CONSTRAINT_SCHEMA, rc.CONSTRAINT_NAME AS RC_CONSTRAINT_NAME, rc.UNIQUE_CONSTRAINT_CATALOG AS RC_UNIQUE_CONSTRAINT_CATALOG, rc.UNIQUE_CONSTRAINT_SCHEMA AS RC_UNIQUE_CONSTRAINT_SCHEMA, rc.UNIQUE_CONSTRAINT_NAME AS RC_UNIQUE_CONSTRAINT_NAME, rc.MATCH_OPTION AS RC_MATCH_OPTION, rc.UPDATE_RULE AS RC_UPDATE_RULE, rc.DELETE_RULE AS RC_DELETE_RULE, rc.TABLE_NAME AS RC_TABLE_NAME, rc.REFERENCED_TABLE_NAME AS RC_REFERENCED_TABLE_NAME, kcu.CONSTRAINT_CATALOG AS KCU_CONSTRAINT_CATALOG, kcu.CONSTRAINT_SCHEMA AS KCU_CONSTRAINT_SCHEMA, kcu.CONSTRAINT_NAME AS KCU_CONSTRAINT_NAME, kcu.TABLE_CATALOG AS KCU_TABLE_CATALOG, kcu.TABLE_SCHEMA AS KCU_TABLE_SCHEMA, kcu.TABLE_NAME AS KCU_TABLE_NAME, kcu.COLUMN_NAME AS KCU_COLUMN_NAME, kcu.ORDINAL_POSITION AS KCU_ORDINAL_POSITION, kcu.POSITION_IN_UNIQUE_CONSTRAINT AS KCU_POSITION_IN_UNIQUE_CONSTRAINT, kcu.REFERENCED_TABLE_SCHEMA AS KCU_REFERENCED_TABLE_SCHEMA, kcu.REFERENCED_TABLE_NAME AS KCU_REFERENCED_TABLE_NAME, kcu.REFERENCED_COLUMN_NAME AS KCU_REFERENCED_COLUMN_NAME FROM information_schema.REFERENTIAL_CONSTRAINTS rc INNER JOIN information_schema.KEY_COLUMN_USAGE kcu ON rc.CONSTRAINT_NAME = kcu.CONSTRAINT_NAME WHERE rc.CONSTRAINT_SCHEMA = :dbName AND rc.REFERENCED_TABLE_NAME = :tName AND kcu.REFERENCED_COLUMN_NAME = :relatedColumn;');

			// Підставляємо значення параметрів та виконуємо запит.
			$Sth->execute(['dbName' => $dbName, 'tName' => $tName, 'relatedColumn' => $relatedColumn]);

			$res = $Sth->fetchAll(\PDO::FETCH_ASSOC);

			// Групуємо результати запиту за іменами пов'язаних таблиць.
			foreach ($res as $row) {
				$this->tblData[$tName]['foreignKeys'][$row['KCU_TABLE_NAME']][] = $row;
			}
		}

		return $this->tblData[$tName]['foreignKeys'];
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
