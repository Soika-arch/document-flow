<?php

namespace core;

use \libs\query_builder\SelectQuery;

/**
 * Цей клас відповідає за отримання зрізів даних з бази даних на основі певних умов. Основні функції
 * цього класу включають побудову SQL-запитів для отримання даних, визначення кількості рядків, що
 * відповідають умовам запиту, та вибірку конкретного зрізу даних.
 */
class RecordSliceRetriever {

	use traits\SetGet;

	/**
	 * @var \libs\query_builder\SelectQuery об'єкт класу SelectQuery, який представляє основний
	 * SQL-запит.
	 */
	protected \libs\query_builder\SelectQuery $SQL;

	/**
	 * @var \libs\query_builder\SelectQuery об'єкт класу SelectQuery, який використовується для
	 * підрахунку загальної кількості рядків, що відповідають умовам запиту.
	 */
	protected \libs\query_builder\SelectQuery $SQLRowsCount;

	/**
	 * @var int Порядковий номер першого елемента у поточному зрізі відносно загальної кількості
	 * записів у властивості $this->numMatchingRecords.
	 */
	protected string $firstIndexNum;

	/**
	 * @var int загальна кількість рядків які відповідають поточному запиту без обмежень limit та
	 * offset.
	 */
	protected int $numMatchingRecords;

	/**
	 * @var int порядковий номер першого зипису в отриманому зрізі відносно заральної кількості
	 * записів, які відповідають заданим параметрам.
	 */
	protected int $firstRowNum;

	/**
	 * @var int максимальна кількість записів в одному запитуваному зрізі.
	 */
	protected int $sliceSize;

	/**
	 * @var int Номер поточного зрізу.
	 */
	protected int $sliceNum;

	/**
	 * @var int загальна кількість зрізів, яка відповідає поточному SQL-запиту.
	 */
	protected int $quantity;

	/**
	 *
	 */
	public function __construct (SelectQuery $SQL=null) {
		if (! isset($SQL)) $this->SQL = db_getSelect();
		else $this->SQL = $SQL;
	}

	/**
	 * Ініціалізує та повертає властивість $this->SQLRowsCount.
	 * @return \libs\query_builder\SelectQuery
	 */
	protected function get_SQLRowsCount () {
		if (! isset($this->SQLRowsCount)) {
			if ($this->SQL->isDistinct()) {
				$this->SQLRowsCount = db_getSelect();
				$sql = $this->SQL->prepare()->queryString;

				$this->SQLRowsCount
					->columns(['C' => $this->SQLRowsCount->raw('count(*)')])
					->from($this->SQLRowsCount->raw('('. trim($sql, ';') .') AS SUB_FROM'));

				// throw new DbException(5003, [
				// 	'SQL' => $this->SQL, 'queryString' => $this->SQL->prepare()->queryString
				// ]);
			}
			else {
				$this->SQLRowsCount = clone $this->SQL;

				$this->SQLRowsCount
					->clearColumns()
					->clearOffset()
					->clearLimit()
					->columns([$this->SQLRowsCount->raw('COUNT(*) AS C')]);
			}
		}

		return $this->SQLRowsCount;
	}

	/**
	 *
	 */
	protected function set_SQLRowsCount (\libs\query_builder\SelectQuery $SQLRowsCount) {
		$this->SQLRowsCount = $SQLRowsCount;
	}

	/**
	 * @param string|array $table Table name
	 * @return self
	 */
	public function from ($table) {
		$this->SQL->from($table);

		return $this;
	}

	/**
	 * This method will append any passed argument to the list of fields to be selected.
	 * @param array $columns The columns as array
	 * @return self
	 */
	public function columns (array $columns) {
		$this->SQL->columns($columns);

		return $this;
	}

	/**
	 * Where AND condition.
	 * @return self
	 */
	public function where (string $l, string $op, string $r) {
		$this->SQL->where($l, $op, $r);

		return $this;
	}

	/**
	 * @param string $fields Column name(s)
	 * @return self
	 */
	public function orderBy (string $fields) {
		$this->SQL->orderBy($fields);

		return $this;
	}

	/**
	 * Отримання кількості рядків для поточного стану SQL-запиту.
	 * @return int
	 */
	public function getRowsCount () {
		$c = db_selectCell($this->get_SQLRowsCount());
		unset($this->SQLRowsCount);

		return $c;
	}

	/**
	 * @param int $sliceNum номер зріза який треба отримати згідно існуючих параметрів.
	 * @param int $sliceSize максимальна кількість елементів в одному зрізі.
	 * @return array
	 */
	public function select (int $sliceSize, int $sliceNum=1, $mode=\PDO::FETCH_ASSOC) {
		$this->sliceSize = $sliceSize;
		$this->sliceNum = $sliceNum;
		$offset = ($this->sliceSize * $sliceNum) - $this->sliceSize;
		$this->firstIndexNum = $offset + 1;
		$this->numMatchingRecords = $this->getRowsCount();
		$this->quantity = ceil($this->numMatchingRecords / $this->sliceSize);

		$this->SQL
			->limit($this->sliceSize)
			->offset($offset);

		return db_select($this->SQL, $mode);
	}

	/**
	 * @return array
	 */
	public function selectCol (int $sliceSize, int $sliceNum=1, $mode=\PDO::FETCH_COLUMN) {

		return $this->select($sliceSize, $sliceNum, $mode);
	}
}
