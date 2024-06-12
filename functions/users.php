<?php

// Функції БД отримання та маніпуляції данними користувачів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Отримання записів усіх користувачів, за вказаною назвою статуса.
 * @return array
 */
function users_getByUserStatus (string $statusName, array $columns=['*']) {
	$SQL = db_getSelect()
		->columns($columns)
		->from(DbPrefix .'users')
		->join(DbPrefix .'users_rel_statuses', 'usr_id_user', '=', 'us_id')
		->join(DbPrefix .'user_statuses', 'uss_id', '=', 'usr_id_status')
		->where('uss_name', '=', $statusName);

	return db_select($SQL);
}

/**
 * Отримання записів усіх користувачів, які вказали свої us_id_tg.
 * @return array
 */
function users_getTelegramData (int|null $accessLevel=null) {
	$SQL = db_getSelect()
		->columns(['us_id'])
		->from(DbPrefix .'users')
		->where('us_id_tg', '!=', null);

	if ($accessLevel) {
		$SQL
			->join(DbPrefix .'users_rel_statuses', 'usr_id_user', '=', 'us_id')
			->join(DbPrefix .'user_statuses', 'uss_id', '=', 'usr_id_status')
			->where('uss_access_level', '<', $accessLevel);
	}

	return db_select($SQL);
}
