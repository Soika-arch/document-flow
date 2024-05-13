<?php

namespace core\db_record;

use core\exceptions\ClassException;
use core\exceptions\DbException;
use core\exceptions\DbRecordException;

/**
 * Нащадки даного класу ініціалізуються рядком конкретної таблиці БД, та надають інтерфейс управління
 * цим рядком.
 */
class DbRecord {

	/** @var int значення стовпця id поточного рядка таблиці БД. */
	protected int $id;
	/** @var array запис БД (повний рядок) на основі якого створено поточний об'єкт. */
	protected array $dbRow;
	/** @var string|null им'я таблиці поточного об'єкта. */
	protected string|null $tName;
	/** @var string префікс стовпців поточної таблиці. */
	protected string $px;
	/** @var array масив даних зв'язків записів поточної таблиці з іншими таблицями. */
	protected array $foreignKeys;
	/** @var array дані ['ім'я_стовпця' => 'нове значення'], що готуються для оновлення запису. */
	protected array $dataForColumns;

	/**
	 * @param int|null $id поточного запису об'єкту.
	 */
	public function __construct (int|null $id=null, array $dbRow=[]) {
		// Отримання назви таблиці із назви поточного класу.
		if ($this->get_tName()) {
			// Ініціалізація властивостей об'єкта, якщо це не об'єкт класу DbRecord.

			if (isset($id)) $this->id = $id;

			if ($dbRow) $this->dbRow = $dbRow;

			$this->px = db_getColumnsPrefix($this->tName);
		}
	}

	/**
	 * Якщо здійснюється запит властивості, яка представляє стовпець таблиці - повертає його значення.
	 * Якщо такого стовпця не існує - генерується виключення.
	 * Якщо здійснюється запит властивості об'єкта - повертається його значення або null, якщо
	 * воно ще не ініціалізовано.
   * @param string $name ім'я властивості класу
   * @return bool false если запрошенного свойства не существует
   */
  public function __get ($name) {
		if (strpos($name, '_') === 0) {
			// Запит значення поля рядка таблиці БД поточного об'єта.

			// Якщо вже існує - повернути одразу.
			if (isset($this->dbRow[$name])) return $this->dbRow[$name];

			$name = $this->px . substr($name, 1);

			if (db_isTableColumn($this->tName, $name)) {
				// Запитуване поле таблиці існує в таблиці даного об'єкту.

				if ($this->get_dbRow() === []) return false;

				if (array_key_exists($name, $this->dbRow) && is_null($this->dbRow[$name])) {
					// Елемент існує але його значення NULL.

					return null;
				}

				return $this->dbRow[$name];
			}

			// Запитуване поле таблиці НЕ існує в таблиці даного об'єкту.
			dd(__METHOD__, __FILE__, __LINE__,1);
		}
		else {
			// Запит значення властивості поточного класа.

			// Якщо вже існує - повернути одразу.
			if (isset($this->$name)) return $this->$name;

			if (property_exists($this, $name)) {
				$method = "get_". $name;

				if (method_exists($this, $method)) {

					return $this->$method();
				}

				throw new ClassException(2001, ['name' => $name, 'method' => $method]);
			}
			else {
				// Поточний клас не має властивості $this->$name.
				dd(__METHOD__, __FILE__, __LINE__,1);
			}
		}
  }

	/**
   * Якщо властивість $this->$name існує у поточного об'єкта - буде викликано відповідний метод
	 * перезапису властивості, інакше буде згенеровано виключення.
   */
  public function __set (string $name, $value) {
		if (property_exists($this, $name)) {
			$method = "set_". $name;

			if (method_exists($this, $method)) {
				$this->$method($value);
			}
			else {
				// Поточний клас не має метода $method.
				dd(__METHOD__, __FILE__, __LINE__,1);
			}
		}
		else {
			// Поточний клас не має властивості $this->$name.
			dd(__METHOD__, __FILE__, __LINE__,1);
		}
  }

	/**
	 * @return string
	 */
	protected function get_tName () {
		if (! isset($this->tName)) {
			// Отримання назви першої у черзі успадкування класу. Це може бути будь-який клас поточної
			// бібліотеки окрім поточного класу \core\db_record\DbRecord, тому що таблиці DbRecord в БД
			// у нас не існує.
			if ($cl = getPreviousClass($this, __CLASS__)) {
				// Отримання назви таблиці БД для поточного об'єкту з назви класу $cl.
				$this->tName = DbPrefix . lcfirst(substr($cl, (strrpos($cl, '\\') + 1)));
			}
			else {
				$this->tName = '';
			}
		}

		return $this->tName;
	}

	/**
	 * Якщо поточний об'єкт не ініціалізований рядком БД, то $this->dbRow буде пустим масивом.
	 * @return array
	 */
	protected function get_dbRow () {
		if (! isset($this->dbRow)) {
			if (isset($this->id)) $this->initById($this->id);
			else $this->dbRow = [];
		}

		return $this->dbRow;
	}

	/**
	 *
	 */
	protected function get_dataForColumns () {

		return $this->dataForColumns;
	}

	/**
	 * Повертає інформацію про зовнішні ключі для цього об'єкта.
	 * @return array Асоціативний масив з інформацією про зовнішні ключі.
	 * Структура элемента массива:
	 * [
 	 *		'key_column' => 'назва_колонки_з_ключом', // Назва колонки із ключем.
 	 *    'relation_column' => 'назва_колонки_з_відношенням', // Назва колонки з відношенням.
 	 *    'onDelete' => true/false // Прапор, що вказує, що видаляти пов'язані записи під час видалення
	 *														 // основного запису.
 	 * ]
	 */
	protected function get_foreignKeys () {}

	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/**
	 * Ініціалізація $this->dbRow по вказаному значенню стовпця id
	 * @param int $id
	 * @param array $columnsData якщо отримано дані поточного запису, то select запит не буде
	 * виконуватись.
	 * @return $this
	 */
	public function initById (int $id, array $columnsData=[]) {
		/** @var string $idColName повна назва стовпця id з префіксом поточної таблиці. */
		$idColName = $this->px .'id';

		if ($columnsData) {
			$this->dbRow = $columnsData;
		}
		else {
			$SQL = db_getSelect();

			$SQL
				->columns(['*'])
				->from($this->get_tName())
				->where($idColName, '=', $id);

			$this->dbRow = db_selectRow($SQL);
		}

		return $this;
	}

	/**
	 * Додавання нового запису в поточну таблицю і ініціалізація нею поточного об'єкту.
	 * @return false|$this
	 */
	public function set (array $columnsData) {
		$SQL = db_getInsert();

		$SQL
			->into($this->get_tName())
			->set($columnsData);

		$res = db_insertRow($SQL);

		// Якщо запит вставки виконано успішно.
		if ($res['result']) {
			// id нового запису.
			$this->id = $res['lastInsertId'];
			// Додавання стовпця id з його значенням в $columnsData.
			$columnsData[$this->px .'id'] = $this->id;
			/** @var int $c реальна кількість стовпців поточної таблиці. */
			$c = count(db_Db()->tblData[$this->get_tName()]['columns']);

			// Якщо реальна кількість стовпців поточної таблиці співпадає з кількістю стовпців в
			// $columnsData - $columnsData передається в метод $this->initById.
			return ($c === count($columnsData)) ?
				$this->initById($this->id, $columnsData) : $this->initById($this->id);
		}

		return false;
	}

	/**
	 * Видалення запису поточного об'єкта за його id.
	 * @return array
	 */
	public function delete (bool $isDeleteRelations=true) {
		$this->deleteRelations();

		$idName = $this->px .'id';

		$SQL = db_getDelete();

		$SQL
			->from($this->tName)
			->where($idName, '=', $this->_id);

		$res = db_deleteRow($SQL);

		if ($res['rowCount'] > 1) throw new DbException(5001);

		if ($isDeleteRelations)

		unset($this->dbRow);

		return $res;
	}

	/**
	 * Видалення зв'язаних записів інших таблиць.
	 */
	public function deleteRelations () {
		$foreignKeys = $this->get_foreignKeys();

		if ($foreignKeys) {
			foreach ($foreignKeys as $tName => $relData) {
				if (! $relData['onDelete']) continue;

				$keyColumnName = '_'. $relData['key_column'];

				$SQL = db_getDelete();

				$SQL
					->from($tName)
					->where($relData['relation_column'], '=', $this->$keyColumnName);

				db_delete($SQL);
			}
		}
	}

	/**
	 * Видалення запису поточного об'єкта у разі значення null зазначених полів.
	 * @param array $columns назви стовпців, які повинні мати значення null видалення запису.
	 */
	function deleteIfNullable (array $columns) {
		$idName = $this->px .'id';
		dd('', __FILE__, __LINE__,1);
		if (isset($this->dbRow[$idName])) {
			$conditions = [];
			$conditions[] = [$idName, '=', $this->dbRow[$idName]];

			foreach ($columns as $colName) $conditions[] = [$colName, '=', null];

			$res = $this->T->delete($conditions);
			dd($res, __FILE__, __LINE__,1);

			return $res;
		}

		dd('', __FILE__, __LINE__,1);
		return false;
	}

	/**
	 * Подготавливает данные для перезаписи значения указанного столбца текущей записи.
	 */
	public function upColumn (string $colName, string $colValue=NULL) {
		dd('', __FILE__, __LINE__,1);

		if (strval($value) !== $colValue) $this->dataForColumns[$colName] = $colValue;

		return $this;
	}

	/**
	 * Оновлення запису в БД поточного об'єкту.
	 * За наявності поля change_date - оновлюється його значення на поточну дату.
	 * @param array $updated нові значення стовпців.
	 * @return array
	 */
	public function update (array $updated) {
		/** @var string ім'я поточної таблиці. */
		$tName = $this->get_tName();
		/** @var string префікс стовпців поточної таблиці. */
		$px = $this->px;
		/** @var string можлива назва поля часу останньої зміни поточного запису. */
		$chDtColName = $px .'change_date';
		/** @var string можлива назва поля часу останнього доступу до поточного запису. */
		$acDtColName = $px .'access_date';

		if (db_Db()->isTableColumn($tName, $chDtColName)) {
			if (! isset($updated[$chDtColName])) $updated[$chDtColName] = date('Y-m-d H:i:s');
		}

		if (db_Db()->isTableColumn($tName, $acDtColName)) {
			if (! isset($updated[$acDtColName])) $updated[$acDtColName] = date('Y-m-d H:i:s');
		}

		$SQL = db_getUpdate();
		$SQL->table($this->tName)->where($px .'id', '=', $this->_id)->set($updated);

		$res = db_update($SQL);

		// Якщо запит оновлення запису успішний - повертається $this.
		if ($res['result'] && ($res['affectedRowCount'] <= 1)) return $this;

		throw new DbRecordException(6000);
	}
}
