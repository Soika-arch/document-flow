<?php

// Функції взаємодії з Telegram.

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

use \core\db_record\tg_messages;

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 * Максимально відправляє 4096 символів (4096 байт в Unicode UTF-8).
 */
function tg_sendMsg (int $chatId, string $text, string $parseMode='markdown') {
	if (strlen($text) > 4096) {
		tg_sendMsg(TgAdmin, "❇ *Error*\n\nОтриманий рядок перевищує 4096 байт для відправки в".
			" TG бот !\nПовідомлення урізано для відправки.");
		$text = mb_substr($text, 0, 4096);
	}

	$url = 'https://api.telegram.org/bot'. TgBotToken .'/sendMessage';

	$ch = curl_init($url);

	$options = [
		'chat_id' => $chatId,
		'text' => $text,
	];

	$options['parse_mode'] = $parseMode;

	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTP09_ALLOWED, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $options);

	$res = curl_exec($ch);
	curl_close($ch);

	ob_clean();

	if ($res) {

		return (new tg_messages(null))->set([
			'tgm_chat_id' => $chatId,
			'tgm_msg' => $text,
			'tgm_add_date' => tm_getDatetime()->format('Y-m-d H:i:s')
		]);
	}

	return false;
}

/**
 * Дебаг через Telegram.
 */
function tg_dd (mixed $data) {
	tg_sendMsg(TgAdmin, 'ss');
	// tg_sendMsg(TgAdmin, json_encode($data), 'text');
	exit;
}
