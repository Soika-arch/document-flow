<?php

// Функції, пов'язані з cron задачами.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * @return array
 */
function cron_getTasks (string $isActive='y') {
	$table = DbPrefix .'cron_tasks';

	$SQL = db_getSelect()
		->columns([$table .'.*'])
		->from($table)
		->where('crt_is_active', '=', $isActive);

	return db_select($SQL);
}
