<?php

// Функції, пов'язані з обробкою документів модуля df.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * @return array
 */
function df_receiveDocumentsAtControl (string $table, array $columns) {
	$table = DbPrefix . $table;
	$px = db_Db()->getColPxByTableName($table);

	$SQL = db_getSelect()
		->columns($columns)
		->from($table)
		->join(DbPrefix .'users', 'us_id', '=', $px .'id_assigned_user')
		->where($px .'execution_date', '=', null)
		->where($px .'date_of_receipt_by_executor', '!=', null)
		->where($px .'id_execution_control', '!=', null)
		->where($px .'trash_bin', '=', null);

	return db_select($SQL);
}
