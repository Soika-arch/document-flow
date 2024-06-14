<?php

namespace core;

use \Doctrine\DBAL\Query\QueryBuilder;

/**
 * Цей клас відповідає за отримання зрізів даних з бази даних на основі певних умов. Основні функції
 * цього класу включають побудову SQL-запитів для отримання даних, визначення кількості рядків, що
 * відповідають умовам запиту, та вибірку конкретного зрізу даних.
 */
class RecordSliceRetriever {

	use traits\SetGet;

	/**
	 * @var \Doctrine\DBAL\Query\QueryBuilder об'єкт класу QueryBuilder, який представляє основний
	 * SQL-запит.
	 */
	protected \Doctrine\DBAL\Query\QueryBuilder $QB;

	/**
	 * @var \Doctrine\DBAL\Query\QueryBuilder об'єкт класу QueryBuilder, який використовується для
	 * підрахунку загальної кількості рядків, що відповідають умовам запиту.
	 */
	protected \Doctrine\DBAL\Query\QueryBuilder $QBCount;

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
	public function __construct (QueryBuilder $QB=null) {
		$this->QB = $QB;
		$this->QBCount = clone $QB->setFirstResult(0)->setMaxResults(null);
	}

	/**
	 * Ініціалізує та повертає властивість $this->QBCount.
	 * @return \Doctrine\DBAL\Query\QueryBuilder
	 */
	protected function get_QBCount () {
		if (! isset($this->QBCount)) {
			if ($this->QB->isDistinct()) {
				dd($this->QBCount, __FILE__, __LINE__,1);
			}
			else {
				$this->QBCount = clone $this->QB;

				$this->QBCount
					->clearColumns()
					->clearOffset()
					->clearLimit()
					->columns([$this->QBCount->raw('COUNT(*) AS C')]);
			}
		}

		return $this->QBCount;
	}

	/**
	 *
	 */
	protected function set_QBCount (\Doctrine\DBAL\Query\QueryBuilder $QBCount) {
		$this->QBCount = $QBCount;
	}

	/**
	 * Отримання кількості рядків для поточного стану SQL-запиту.
	 * @return int
	 */
	public function getRowsCount () {

		return $this->QBCount->executeQuery()->rowCount();
	}

	/**
	 * @param int $sliceNum номер зріза який треба отримати згідно існуючих параметрів.
	 * @param int $sliceSize максимальна кількість елементів в одному зрізі.
	 * @return array
	 */
	public function select (int $sliceSize, int $sliceNum=1) {
		$this->sliceSize = $sliceSize;
		$this->sliceNum = $sliceNum;
		$offset = ($this->sliceSize * $sliceNum) - $this->sliceSize;
		$this->firstIndexNum = $offset + 1;
		$this->numMatchingRecords = $this->getRowsCount();
		$this->quantity = ceil($this->numMatchingRecords / $this->sliceSize);

		$this->QB
			->setFirstResult($offset)
			->setMaxResults($this->sliceSize);

		return $this->QB->executeQuery()->fetchAllAssociative();
	}

	/**
	 * @return array
	 */
	public function selectCol (int $sliceSize, int $sliceNum=1, $mode=\PDO::FETCH_COLUMN) {

		return $this->select($sliceSize, $sliceNum, $mode);
	}
}
