<?php

namespace core;

/**
 * Клас для отримання пагінації.
 */
class Pagination {

	use traits\SetGet;

	/**
	 * @var \libs\query_builder\SelectQuery побудовник SQL-запиту для отримання властивості
	 * $this->numMatchingRecords.
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

	/** @var \libs\query_builder\SelectQuery основний побудовник SQL-запиту. */
	protected \libs\query_builder\SelectQuery $SQL;
	/** @var int $sliceCount максимальна кількість записів в одному запитуваному зрізі. */
	protected int $sliceCount;
	/** @var int загальна кількість зрізів, яка відп. поточному SQL-запиту. */
	protected int $quantity;
	/** @var int кількість перших сторінок меню пагінації. */
	protected int $firstPages;
	/** @var array кількість середніх сторінок меню пагінації. */
	protected array $averagePages;
	/** @var int кількість останніх сторінок меню пагінації. */
	protected int $lastPages;

	/**
	 * @param int $sliceCount кількість записів в запитуваному зрізі.
	 */
	public function __construct (int $sliceCount) {
		$this->sliceCount = $sliceCount;

		$this->SQL = db_getSelect();
	}

	/**
	 * @return int
	 */
	protected function get_sliceCount () {

		return $this->sliceCount;
	}

	/**
	 * Ініціалізує та повертає властивість $this->SQLRowsCount.
	 * @return \libs\query_builder\SelectQuery
	 */
	protected function get_SQLRowsCount () {
		if (! isset($this->SQLRowsCount)) {
			$this->SQLRowsCount = clone $this->SQL
				->clearColumns()
				->clearOffset()
				->clearLimit();

			$this->SQLRowsCount->columns([$this->SQLRowsCount->raw('COUNT(*) AS C')]);
		}

		return $this->SQLRowsCount;
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
	 *
	 */
	protected function setSlice (int $sliceNum) {
		$this->numMatchingRecords = $this->getRowsCount();
		$this->quantity = ceil($this->numMatchingRecords / $this->sliceCount);
		$offset = ($this->sliceCount * $sliceNum) - $this->sliceCount;
		$this->firstIndexNum = $offset + 1;

		$this->SQL
			->limit($this->sliceCount)
			->offset($offset);
	}

	/**
	 * @return array
	 */
	public function select (int $sliceNum) {
		if (! isset($this->quantity)) $this->setSlice($sliceNum);

		return db_select($this->SQL);
	}

	/**
	 * Обчислення необхідності першої сторінки в меню пагінації.
	 * @return
	 * @param int $pageNum поточна сторінка.
	 * @param int $averagePagesCount максимальна кількість середнього діапазону сторінок.
	 */
	protected function setFirstPages (int $pageNum, int $averagePagesCount) {
		if ($this->quantity === 1) {
			$this->firstPages = 0;
		}
		else if ($this->quantity > 1) {
			if ($pageNum >= intval(ceil($averagePagesCount / 2))) {
				$this->firstPages = 1;
			}
			else {
				$this->firstPages = 0;
			}
		}
	}

	/**
	 * Обчислення довжини середнього діапазону меню пагінації.
	 * @param int $averagePagesCount максимальна кількість середнього діапазону сторінок.
	 * @return int
	 */
	protected function getMidRangeLength (int $averagePagesCount) {
		if ($this->quantity === 1) {
			$c = 1;
		}
		else if ($this->quantity < $averagePagesCount) {
			$c = $this->quantity;
		}
		else if ($this->quantity >= $averagePagesCount) {
			$c = $averagePagesCount;
		}
		else {
			$c = 0;
		}

		// Якщо реальна кількість сторінок менша за $averagePagesCount.
		if ($c < $averagePagesCount) $averagePagesCount = $c;

		return $averagePagesCount;
	}

	/**
	 * Обчислення першого номеру сторінки для середнього діапазону пагінації.
	 * @return int
	 */
	protected function getFirstPageNumberForMiddleRange (int $pageNum, int $averagePagesCount) {
		$n = $pageNum - intval(ceil($averagePagesCount / 2));

		return ($n <= 0) ? 1 : $n;
	}

	/**
	 * Обчислення середнього (основного) діапазону в меню пагінації.
	 * @return
	 * @param int $pageNum поточна сторінка.
	 * @param int $averagePagesCount максимальна кількість середнього діапазону сторінок.
	 */
	protected function setAveragePagesData (int $pageNum, int $averagePagesCount) {
		/** @var int довжина середнього діапазону. */
		$midRangeLength = $this->getMidRangeLength($averagePagesCount);
		$firstRangePage = $this->getFirstPageNumberForMiddleRange($pageNum, $averagePagesCount);
		// dd($midRangeLength, __FILE__, __LINE__,1);
		for ($n = $firstRangePage; $n <= $midRangeLength; $n++) {
			$this->averagePages[] = $n;
		}

		dd([$this->firstPages, $firstRangePage, $midRangeLength, $this->averagePages], __FILE__, __LINE__,1);
	}

	/**
	 * @return self
	 * @param int $pageNum поточна сторінка.
	 * @param int $maxFirstPagesCount максимальна кількість середнього діапазону сторінок.
	 */
	public function keepDynamicPagination (int $pageNum, int $averagePagesCount) {
		if (! isset($this->quantity)) $this->setSlice($pageNum);

		$this->setFirstPages($pageNum, $averagePagesCount);
		$this->setAveragePagesData($pageNum, $averagePagesCount);
		dd($this, __FILE__, __LINE__,1);
	}
}
