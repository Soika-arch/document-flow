<?php

namespace core;

class Pagination {

	use traits\SetGet;

	protected \libs\query_builder\SelectQuery $SQL;
	protected int $sliceCount;
	protected int $sliceNum;
	protected string $orderBy;

	/**
	 * @var int порядковий номер першого елемента в отриманому зрізі відносно заральної кількості
	 * записів, які відповідають заданим параметрам.
	 */
	protected int $firstElementNum;

	/**
	 * @param int $sliceCount кількість записів в запитуваному зрізі.
	 * @param int $sliceNum номер зріза (сторінки пагінації).
	 */
	public function __construct (int $sliceCount, int $sliceNum=1) {
		$this->sliceCount = $sliceCount;
		$this->sliceNum = $sliceNum;

		$this->SQL = db_getSelect();
	}

	/**
	 * @return int
	 */
	protected function get_sliceCount () {
		if (! isset($this->sliceCount)) $this->sliceCount = 10;

		return $this->sliceCount;
	}

	/**
	 * @return string
	 */
	protected function get_orderBy () {
		if (isset($this->orderBy)) return $this->orderBy;
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
	 * @param array ...$fields Column name(s)
	 * @return self
	 */
	public function orderBy ($fields) {
		$this->SQL->orderBy($fields);

		return $this;
	}

	/**
	 * @return array
	 */
	public function select () {
		$this->SQL
			->limit($this->get_sliceCount())
			->offset($this->sliceNum);

		return db_select($this->SQL);
	}
}
