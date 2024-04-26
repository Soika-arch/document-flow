<?php

namespace core\db_record;

use core\exceptions\ClassException;
use core\exceptions\DbRecordException;

/**
 * Нащадки даного класу ініціалізуються рядком конкретної таблиці БД, та надають інтерфейс управління
 * цим рядком.
 */
class DbRecord {

	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/** [1] Свойства и константы. */

	// Значення стовпця id поточного рядка таблиці БД.
	protected int $id;
	// Запис БД (повний рядок) на основі якого створено поточний об'єкт.
	protected array $dbRow;
	// Сокращенное (без префикса и БД) имя таблицы текущего объекта.
	protected string|null $tName;
	// Префикс столбцов.
	protected string $px;
	// Масив даних зв'язків записів поточної таблиці з іншими таблицями.
	protected array $relations;
	// Дані ['ім'я_стовпця' => 'нове значення'], що готуються для оновлення запису.
	protected array $dataForColumns;

	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/** [1] Магические методы. */

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

			err("classes.Db", 6, __FILE__, __LINE__, debug_backtrace(), [
				'tName' => $this->tName,
				'colName' => $name
			]);
		}
		else {
			// Запит значення властивості поточного об'єта.

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
				err("classes", 1, __FILE__, __LINE__, debug_backtrace(),
					['class' => get_called_class(), 'name' => $name]);
			}
		}
  }

	/**
   *
   */
  public function __set (string $name, $value) {
		if (property_exists($this, $name)) {
			$method = "set_". $name;

			if (method_exists($this, $method)) {
				$this->$method($value);
			}
			else {
				err("classes", 2, __FILE__, __LINE__, debug_backtrace(),
					['class' => get_called_class(), 'name' => $name, 'method' => $method]);
			}
		}
		else {
			err("classes", 1, __FILE__, __LINE__, debug_backtrace(),
				['class' => get_called_class(), 'name' => $name]);
		}
  }

	/**
	 * Отримання назви першої у черзі успадкування класу. Це може бути будь-який клас поточної
	 * бібліотеки окрім поточного класу \core\db_record\DbRecord, тому що таблиці DbRecord в БД
	 * у нас не існує.
	 * @return string
	 */
	protected function get_tName () {
		if (! isset($this->tName)) {
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

	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/**
	 * Ініціалізація $this->dbRow по вказаному значенню стовпця id
	 * @return $this
	 */
	public function initById (int $id) {
		$idColName = $this->px .'id';
		$SQL = db_getSelect();

		$SQL
			->columns(['*'])
			->from($this->get_tName())
			->where($idColName, '=', $id);

		$this->dbRow = db_selectRow($SQL);

		return $this;
	}

	/**
	 * @return false|$this
	 */
	public function set (array $columnsData) {
		$SQL = db_getInsert();

		$SQL
			->into($this->get_tName())
			->set($columnsData);

		$res = db_insertRow($SQL);

		if ($res['result']) {
			$this->id = $res['lastInsertId'];

			return $this->initById($this->id);
		}

		return false;
	}

	/**
	 * Удаление записи текущего объекта по ее id.
	 * @return bool
	 */
	public function delete () {
		$idName = $this->px .'id';
		$idIndex = '_id';

		dd($this, __FILE__, __LINE__,1);

		return ;
	}

	/**
	 * Удаление записи текущего объекта в случае значения null указанных полей.
	 * @param array $columns названия столбцов, которые должны иметь значение null для удаления записи.
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
		$tName = $this->tName;
		$px = $this->px;
		$chDtColName = $px .'change_date';
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

		if ($res['result'] && ($res['affectedRowCount'] <= 1)) return $this;

		throw new DbRecordException(6000);
	}

	/**
	 *
	 */
	public function absorbObject (string $valName, core\db_record\DbRecord $Obj) {
		$this->$valName = $Obj;
	}
}
