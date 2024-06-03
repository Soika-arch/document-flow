<?php

// Функції БД отримання та маніпуляції данними користувачів.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Отримання записів усіх користувачів, які вказали свої us_id_tg.
 * @return array
 */
function db_users_getTelegramData (int|null $accessLevel=null) {
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
