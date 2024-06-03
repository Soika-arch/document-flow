<?php

// Функції взаємодії з таблицею `user_messages`.

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

use \core\db_record\user_messages;

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 *
 */
function msg_makeHeaderStandart (string $msgHeader) {

	return '<span class="msg-header-standart">'. $msgHeader .'</span>';
}

/**
 *
 */
function msg_makeHeaderWarning (string $msgHeader) {

	return '<span class="msg-header-warning">'. $msgHeader .'</span>';
}

/**
 *
 */
function msg_makeHeaderError (string $msgHeader) {

	return '<span class="msg-header-error">'. $msgHeader .'</span>';
}

/**
 *
 */
function msg_makeHeaderAlarm (string $msgHeader) {

	return '<span class="msg-header-alarm">'. $msgHeader .'</span>';
}

/**
 * @return user_messages|false
 */
function msg_add (int $idUser, int $idSender, string $msg, string $header='', string $msgType='standart') {
	$func = 'msg_makeHeader'. ucfirst($msgType);
	$nowDt = date('Y-m-d H:i:s');

	return (new user_messages(null))->set([
		'usm_id_user' => $idUser,
		'usm_id_sender' => $idSender,
		'usm_header' => $func($header),
		'usm_msg' => $msg,
		'usm_read' => 'n',
		'usm_trash_bin' => 'n',
		'usm_add_date' => $nowDt,
		'usm_change_date' => $nowDt
	]);
}

/**
 * @return array|false
 */
function msg_getAllByUserId (int $idUser, array $orderBy=[], int|null $numSlice=null, int|null $countSlice=null) {

	$SQL = (new Select(['user_messages']))
		->columns(['user_messages.*'])
		->addBindParam('idUser', $idUser)
		->where(['and' => 'usm_trash_bin = "n"']);

	if ($orderBy !== []) $SQL->orderBy($orderBy);

	return db_select($SQL->sliceByUser($idUser, $numSlice, $countSlice)->get(), $SQL->bindParams);
}
