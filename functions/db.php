<?php

// Функції взаємодії з БД.

use core\Db;

/**
 *
 */
function db_queryDump (string $sql, array $binds=[]) {
	$dumpData = [];
	$Pdo = Db::instance()->dbh;
	$Pdo->beginTransaction();
	$Sth = $Pdo->prepare($sql);
	ob_start();
	$Sth->execute($binds);
  $Sth->debugDumpParams();
  $sqlDump = ob_get_contents();
	$sqlDump = str_replace("\n", ' ', $sqlDump);
	preg_match('#^(.*?\] )(.*?) Sent SQL#', $sqlDump, $m);
	$dumpData['sql2'] = trim($m[2]);
	preg_match('#(Sent SQL:.*?\] )(.*?) Params:#', $sqlDump, $m);
	$dumpData['sentSql'] = trim($m[2]);
	preg_match('#Params:.*$#', $sqlDump, $m);
	$dumpData['params'] = trim($m[0]);
	$dumpData['Sth'] = $Sth;
  ob_end_clean();
	dd([$dumpData, debug_backtrace()], __FILE__, __LINE__);
	$Pdo->rollBack();
	exit();
}

/**
 * @param string $sql
 * @return array
 */
function db_select (string $sql, array $binds=[], int $mode=PDO::FETCH_ASSOC) {
	$sth = Db::getInstance()->dbh->prepare($sql);

	$sth->execute($binds);
	$rows = $sth->fetchAll($mode);

	if (intval($sth->errorCode()) !== 0) {
		dd($sth, __FILE__, __LINE__,1);
	}

	return $rows;
}
