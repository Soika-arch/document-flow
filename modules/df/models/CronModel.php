<?php

namespace modules\df\models;

use \core\User;
use \core\db_record\users;
use \modules\df\models\MainModel;
use \ZipArchive;

/**
 * Модель пошуку документів.
 */
class CronModel extends MainModel {

	/**
	 * @return array
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 *
	 */
	public function mainPage () {


	}

	/**
	 * Повідомлення користувачів про непрочитані повідомлення.
	 */
	public function notifyAboutUnreadMessages () {
		$users = users_getTelegramData(5);

		foreach ($users as $rowUser) {
			$UsTemp = new User($rowUser['us_id']);

			if ($countMsgs = $UsTemp->getUnreadMessagesCount()) {
				if ($UsTemp->_id_tg) {
					$msg = "❇️ Ви маєте ". $countMsgs ." непрочитаних [повідомлень](". url('/messages') .")";
					tg_sendMsg($UsTemp->_id_tg, $msg);
				}

				if ($UsTemp->_email) {
					$msg = '<html><head><title>Document-flow: непрочитані повідомлення</title></head>'.
						'<body><p>Ви маєте '. $countMsgs .' непрочитаних <a href="'. url('/messages') .
						'">повідомлень</a>.</p></body></html>';

					$headers =
						"MIME-Version: 1.0\r\n".
						"From: \"DF-Admin\" <admin@petamicr.zzz.com.ua>\r\n".
						"Reply-To: vladimirovichser@gmail.com\r\n".
						"Content-type: text/html; charset=UTF-8\r\n";

					mail($UsTemp->_email, 'Document-flow: непрочитані повідомлення', $msg, $headers);
				}
			}
		}
	}

	/**
	 * Повідомлення користувачів про дати контроля.
	 */
	public function notifyAboutControlDate () {
		$documents = df_receiveDocumentsAtControl('incoming_documents_registry', ['idr_id', 'us_id']);
		$this->sendMessagesAboutControlDate('incoming_documents_registry', $documents);
		$documents = df_receiveDocumentsAtControl('internal_documents_registry', ['inr_id', 'us_id']);
		$this->sendMessagesAboutControlDate('internal_documents_registry', $documents);
	}

	/**
	 * Відправлення повідомлень користувачам про дати контроля.
	 */
	protected function sendMessagesAboutControlDate (string $documentType, array $documents) {
		$px = db_Db()->getColPxByTableName(DbPrefix . $documentType);
		$documentType = DirCore .'/db_record/'. $documentType;
		$documentType = trim(str_replace([DirRoot, '/'], '\\', $documentType), '\\');

		foreach ($documents as $rowData) {
			$Doc = new $documentType($rowData[$px .'id']);
			$controlDate = $Doc->NextControlDate->format('Y-m-d');

			if ($controlDate === tm_getDatetime()->format('Y-m-d')) {
				$UsTemp = new users($rowData['us_id']);

				if ($UsTemp->_id_tg) {
					$msg = "❇ Сьогодні контрольна дата документа [". $Doc->displayedNumber ."](".
						$Doc->cardURL .").";

					tg_sendMsg($UsTemp->_id_tg, $msg);
				}

				if ($UsTemp->_email) {
					$msg = '<html><head><title>Document-flow: контрольна дата документа</title></head>'.
						'<body><p>Сьогодні контрольна дата документа <a href="'. $Doc->cardURL .'">'.
						$Doc->displayedNumber .'</a>.</p></body></html>';

					$headers =
						"MIME-Version: 1.0\r\n".
						"From: \"DF-Admin\" <admin@petamicr.zzz.com.ua>\r\n".
						"Reply-To: vladimirovichser@gmail.com\r\n".
						"Content-type: text/html; charset=UTF-8\r\n";

					mail($UsTemp->_email, 'Document-flow: контрольна дата документа', $msg, $headers);
				}

				$msg = 'Сьогодні контрольна дата документа <a href="'. $Doc->cardURL .'">'.
					$Doc->displayedNumber .'</a>';

				msg_add($UsTemp->_id, 1, $msg, 'Контрольна дата документа', 'Warning');
			}
		}
	}

	/**
	 * Бекап таблиць бази даних
	 */
	public function backupOfDatabaseTables () {
		$backDir = DirRoot .'/db_backup';
		$newDirName = $backDir .'/'. date('Y_m_d__H_i');

		if (! is_dir($newDirName)) mkdir($newDirName);

		// Функция для добавления файлов и директорий в архив
		function addFilesToZip($dir, $zipArchive, $zipDir = '') {
			if (is_dir($dir)) {
				if ($dh = opendir($dir)) {
					// Добавляем пустую директорию в архив
					if (!empty($zipDir)) {
						$zipArchive->addEmptyDir($zipDir);
					}
					while (($file = readdir($dh)) !== false) {
						if ($file != '.' && $file != '..') {
							$fullPath = $dir .'/'. $file;
							if (is_dir($fullPath)) {
								// Рекурсивно добавляем директории
								addFilesToZip($fullPath . '/', $zipArchive, $zipDir . $file . '/');
							} else {
								// Добавляем файлы в архив
								$zipArchive->addFile($fullPath, $zipDir . $file);
							}
						}
					}

					closedir($dh);
				}
			}
		}

		$tables = db_Db()->tables;

		foreach ($tables as $tName => $tData) {
			$tableBackFileName = $newDirName .'/'. $tName .'.sql';
			$handle = fopen($tableBackFileName, 'w');
			$PDO = db_Db()->PDO;
			// Отримання структури таблиці.
			$createTableQuery = $PDO->query("SHOW CREATE TABLE `$tName`")->fetch(\PDO::FETCH_ASSOC);
			fwrite($handle, $createTableQuery['Create Table'] . ";\n\n");
			// Отримання даних із таблиці.
			$rows = $PDO->query("SELECT * FROM `$tName`", \PDO::FETCH_ASSOC);

			foreach ($rows as $row) {
				$rowValues = array_map([$PDO, 'quote'], $row);
				fwrite($handle, "INSERT INTO `$tName` VALUES (" . implode(", ", $rowValues) . ");\n");
			}

			fclose($handle);
		}

		$zipFile = $newDirName .'.zip';
		$zip = new ZipArchive();
		$dt = date('d.m.Y H:i:s');

		if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
			addFilesToZip($newDirName, $zip);
			$zip->close();
			chmod($zipFile, 666);

			sendEmailWithAttachment(
				'vladimirovichser@gmail.com',
				'Виконано автобекап бази даних',
				'Cron завдання: створено повний бекап бази даних. Час створення: '. $dt .'.',
				$zipFile, basename($zipFile)
			);

			tg_sendMsg(
				TgAdmin,
				"❇️ Cron завдання: створено повний бекап бази даних. Час створення: `". $dt ."`.\n\n".
					"Лист з архівом БД відправлено на email: vladimirovichser@gmail.com."
			);

			sendEmailWithAttachment(
				'ek.soiku@gmail.com',
				'Виконано автобекап бази даних',
				'Cron завдання: створено повний бекап бази даних. Час створення: '. $dt .'.',
				$zipFile, basename($zipFile)
			);

			tg_sendMsg(
				602635770,
				"❇️ Cron завдання: створено повний бекап бази даних. Час створення: `". $dt ."`.\n\n".
					"Лист з архівом БД відправлено на email: ek.soiku@gmail.com."
			);
		}

		// $d = scandir($backDir);

		// foreach ($d as $dName) {
		// 	if ($dName === '.' || $dName === '..') continue;

		// 	$dirPath = $backDir .'/'. $dName;
		// 	chmodRecursive($dirPath, 0777);
		// 	dd([$dName, is_dir($dirPath), decoct(fileperms($dirPath)), deleteDirectory($dirPath)], __FILE__, __LINE__,1);
		// }

		deleteDirectory($newDirName .'/2024_06_10__06_47');
	}
}
