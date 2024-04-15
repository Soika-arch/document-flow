<?php

namespace core\db_tables;

class Table {

	// Ім'я таблиці.
	protected string $tName;
	// Префікс імені таблиці.
	protected string $tPrefix;
	// Префікс стовпців таблиці.
	protected string $сPrefix;
	// Масив даних зв'язків поточної таблиці з іншими таблицями.
	protected array $relations;


}
