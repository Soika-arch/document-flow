<?php

// Головні функції проєкту.

// Автопідключення класів.

use \core\Debug;
use \core\Header;

/**
 *
 */
function startApp () {
	setlocale(LC_ALL, 'uk_UA');
	session_start();
	Header::getInstance()->addHeader('Content-type: text/html; charset=utf-8', __FILE__, __LINE__);
	ob_start();
}

function classesAutoload () {
	spl_autoload_register(
		function($className) {
			$fname = str_replace('\\', '/', DirRoot .'/'. $className . '.php');

			if (is_file($fname)) {
				require_once $fname;
			}
			else {
				dd([$fname, is_file($fname)], __FILE__, __LINE__,1);
			}
		}
	);
}

function dd (mixed $var, string $fname, string $line, bool $stop=false, bool $saveToFile=false) {
	if (! $stop) global $HTML;
	else $HTML = '';

	$obContent = ob_get_clean();
	$trace = debug_backtrace();
	$f = file($trace[0]["file"]);
	$l = $trace[0]["line"] - 1;
	preg_match( "#^.*?dd\((.*?), __#", $f[$l], $match);

	$HTML .= "<div style=\"margin:0px 0px 10px 0px;padding:10px 0px 10px 0px;background:#e6dbb6;".
		"color:#1a0f68;font-size:17px;\">\n";

	$HTML .= "<div style=\"display:inline-block;margin:5px 5px 0px 10px;padding:2px 10px 2px 10px;'.
		' background:#e4dfdf;\"><i>file: {$fname}, line: {$line}</i></div>\n";

	if (isset($match[1])) {
		$HTML .= "<div style=\"margin:10px 0px 0px 10px;\">&gt;&gt; <span style=\"color:#410ce0;\">".
			$match[1] ."</span></div></div>\n";
	}

	// if ($saveToFile) file_put_contents(PlugPath .'/debug.json', json_encode($var));

	require_once DirRoot .'/core/Debug.php';

	$HTML = $HTML . Debug::var_dump($var) . $obContent;

	if ($stop) {
		echo $HTML;
		exit;
	}
}

/**
 * Обробка закінчення терміну сесії користувача.
 */
function handleSessionExpiration () {
	if (isset($_SESSION['user'])) {
		// Обробка даних сесії користувача.

		if (isset($_SESSION['user']['loginTimestamp'])) {
			if (SessionTimeoutEnabled) {
				if ((microtime(true) - $_SESSION['user']['loginTimestamp']) > SessionTimeout) {
					// Час сесії користувача перевищує максимально дозволений в SESSION_TIMEOUT.

					Header::getInstance()
						->addHeader('Location: '. url('/user/logout'), __FILE__, __LINE__)
						->send();

					exit;
				}
			}

			if (TrackUserActivity) {
				if ((microtime(true) - $_SESSION['user']['lastRequestTimestamp']) > MaxIdleTime) {
					// Час бездіяльності користувача перевищує максимально дозволений.

					Header::getInstance()
						->addHeader('Location: '. url('/user/logout'), __FILE__, __LINE__)
						->send();

					exit;
				}
			}

			$_SESSION['user']['lastRequestTimestamp'] = microtime(true);
		}
	}
}

/**
 * Додавання текстового рядка до глобального HTML сторінки.
 */
function e (string $s) {
	global $HTML;

	$HTML .= $s ."\n";
}

/**
 * Створює URL сторінки для поточного хоста згідно отриманих параметрів.
 */
function url (null|string $s=null, array $p=[]): string {
	if (! is_null($s)) {
		if ($s === '') {
			// Вирізання GET-параметрів від існуючого URL.

			$url = URLHome .'/'. URIPath;
		}
		else if (strpos($s, '/') === 0) {
			// Рядок $s додається до URL корня сайта.

			$url = trim(URLHome .'/'. trim($s, '/'), '/');
		}
		else {
			// Рядок $s додається до поточного URL.

			$url = url('') .'/'. trim($s, '/');
		}
	}
	else {
		// Повний поточний URL.

		$url = URL;
	}

	// Якщо отримані GET-параметри - вони будуть додані до створеного URL.
	return $p ? setURLParams($url, $p) : $url;
}

/**
 * @return string
 */
function setURLParams (string $url, array $params) {
	if (! strpos($url, '?')) $url .= '?';

	foreach ($params as $n => $v) {
		if (strpos($n, '-') === 0) {
			$n = ltrim($n, '-');

			$url = trim(preg_replace('/([&?]?)'. $n .'=[^&]*(&|$)/', '$1', $url), '&');
		}
		else {
			$url .= '&'. $n .'='. $v;
		}
	}

	return str_replace('?&', '?', $url);
}

/**
 * @return string
 */
function addURLParam (string $url, string $n, string $v) {
	if (! strpos($url, '?')) $url .= '?';

	if (strpos($url, $n) !== false) {
		$url = trim(preg_replace('/([&?]?)'. $n .'=[^&]*(&|$)/', '$1', $url), '&');
	}

	return $url .'&'. $n .'='. $v;
}

/**
 * @return string
 */
function delURLParam (string $url, string $pName) {

	return trim(preg_replace('/([&?]?)'. $pName .'=[^&]*(&|$)/', '$1', $url), '&?');
}

/**
 * Перетворює масив аргументів у асоціативний масив.
 * Кожен елемент вхідного масиву повинен мати формат `ключ:значення`.
 * Функція розбиває ці елементи на ключ та значення і повертає асоціативний масив.
 * @param array $args Масив аргументів, де кожен елемент у форматі `ключ:значення`.
 * @return array Асоціативний масив, де ключі - це частини до двокрапки, а значення - після.
 */
function funcGetArgs (array $args) {
	$p = [];

	foreach ($args as $v) {
		// Розділяємо рядок на частини до і після двокрапки
		list($key, $value) = explode(':', $v, 2);
		// Додаємо до асоціативного масиву
		$p[$key] = $value;
	}

	return $p;
}

/**
 * Отримання ip-адреси користувача.
 * @return string
 */
function getUserIp () {
	if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
		// IP адрес посетителя, если доступен
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		// IP адрес через прокси
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		// Обычный IP адрес
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	return $ip;
}

/**
 * Отримання user-agent користувача.
 * @return string
 */
function getUserAgent () {
	if (isset($_SERVER['HTTP_USER_AGENT'])) return $_SERVER['HTTP_USER_AGENT'];
}

/**
 * Ця функція знаходить попередній клас об'єкта $obj до кінцевого класу $endClass.
 */
function getPreviousClass (object $Obj, string $endClass): string {
	// Отримання назви класу поточного об'єкта $obj.
	$currentClass = get_class($Obj);
	// У подальшому дочірній клас відносно класу $currentClass.
	$previous = '';

	// Цикл виконується поки не дійде до класу $endClass.
	while ($currentClass !== $endClass) {
		$previous = $currentClass;
		$currentClass = get_parent_class($currentClass);
	}

	return $previous;
}

/**
 * Генерує випадковий рядок заданої довжини з вказаного набору символів.
 * @param int $strLength Довжина випадкового рядка. За замовчуванням 5.
 * @param string $chars Набір символів, з яких генерується рядок. За замовчуванням
 * '0123456789abcdefghijklmnopqrstuvwxyz'.
 * @return string Випадковий рядок заданої довжини з вказаного набору символів.
 * @throws Exception Якщо генерація випадкового числа не вдалася.
 */
function randStr ($strLength=5, $chars='0123456789abcdefghijklmnopqrstuvwxyz') {
	$charsLength = strlen($chars);
	$randStr = '';

	for($i = 0; $i < $strLength; $i++) $randStr .= $chars[random_int(0, $charsLength - 1)];

	return $randStr;
}

/**
 * Отримує значення з масиву за ключем з можливістю вказання значення за замовчуванням та обробки
 * порожніх значень.
 * @param array $arr Масив, з якого потрібно отримати значення.
 * @param string $key Ключ, значення якого потрібно отримати.
 * @param mixed $defaultValue Значення, яке повертається, якщо ключ не знайдено у масиві. За
 * замовчуванням null.
 * @param bool $nullForEmpty Чи повертати null для порожніх значень (null, порожній рядок, false). За
 * замовчуванням true.
 * @return mixed Значення з масиву або значення за замовчуванням, можливо null, якщо $nullForEmpty
 * дорівнює true і значення є порожнім.
 */
function getArrayValue (array $arr, string $key, $defaultValue=null, bool $nullForEmpty=true) {
	// Отримуємо значення з масиву за ключем або використовуємо значення за замовчуванням, якщо ключ
	// не знайдено.
	$v = $arr[$key] ?? $defaultValue;

	// Перевіряємо, чи є значення порожнім (null, порожній рядок або false).
	if ($v === null || $v === '' || $v === false) {
		// Якщо параметр $nullForEmpty встановлено в true, повертаємо null для порожніх значень.
    // Інакше повертаємо саме значення.

		return $nullForEmpty ? null : $v;
	}

	// Якщо значення не є порожнім, повертаємо його.
	return $v;
}

/**
 * Повертає надане значення, якщо його можна привести до значення true, інакше повертає значення
 * за замовчуванням.
 * @param mixed $value Значення для перевірки.
 * @param string $default Значення за умовчанням, яке повертається, якщо значення $value має
 * значення false.
 * @return mixed Значення, якщо воно має значення true, інакше значення за замовчуванням.
 */
function getOrDefault (mixed $v, string $defaul='') {
	return $v ? $v : $defaul;
}

/**
 * Перетворює число в рядок із провідними нулями до заданої довжини.
 *
 * @param int $number Число перетворення.
 * @param int $length Цільова довжина рядка.
 * @return string Перетворений рядок з провідними нулями.
 */
function formatWithLeadingZeros (int $number, int $length) {

	return sprintf('%0'. $length .'d', $number);
}

/**
 * Перевірка автентичності Cron поточного хостинга.
 * @return bool
 */
function isCron () {
	$Us = rg_Rg()->get('Us');

	if (strpos($Us->VR->_user_agent, 'python-requests') === 0) {
		$msg = "‼️ Cron демон не пройшов перевірку: ";

		if ($Us->VR->_user_agent !== 'python-requests/2.25.1') {
			tg_sendMsg(TgAdmin, $msg ." !== 'python-requests/2.25.1'");
		}

		if ($Us->VR->_uri === 'public/index.php') {
			if ($Us->VR->_ip === '37.48.72.4') {
				// Отримання поточних хвилин.
				$minutes = (int)(new DateTime())->format('i');

				// Переврка кратності 15 хвилинам (Cron виконується кожні 15 хвилин).
				if (($minutes % 15) === 0) {

					return true;
				} else {
					tg_sendMsg(TgAdmin, $msg ."час виконання не кратний 15 хвилинам");
				}
			}
			else {
				tg_sendMsg(TgAdmin, $msg ."ip !== '37.48.72.4'");
			}
		}
		else {
			tg_sendMsg(TgAdmin, $msg ."uri !== 'public/index.php'");
		}
	}

	return false;
}

// Функция для отправки email с вложением
function sendEmailWithAttachment ($to, $subject, $message, $filePath, $fileName) {
	$headers = "From: \"DF-Admin\" <admin@petamicr.zzz.com.ua>";
	$headers .= "\r\nReply-To: vladimirovichser@gmail.com";

	// Читаем файл и кодируем его в base64
	$fileContent = file_get_contents($filePath);
	$fileContent = chunk_split(base64_encode($fileContent));

	// Создаем границу для разделения частей письма
	$separator = md5(time());

	// Заголовки для письма с вложением
	$headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"" . $separator . "\"";

	// Тело письма
	$body = "--" . $separator . "\r\n";
	$body .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
	$body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	$body .= $message . "\r\n";

	// Добавляем вложение
	$body .= "--" . $separator . "\r\n";
	$body .= "Content-Type: application/zip; name=\"" . $fileName . "\"\r\n";
	$body .= "Content-Transfer-Encoding: base64\r\n";
	$body .= "Content-Disposition: attachment; filename=\"" . $fileName . "\"\r\n\r\n";
	$body .= $fileContent . "\r\n";
	$body .= "--" . $separator . "--";

	// Отправка письма
	if (mail($to, $subject, $body, $headers)) return true;

	return false;
}

// Функция для рекурсивной установки прав доступа
function chmodRecursive ($dir, $mode) {
	if (! is_dir($dir)) return false;

	$contents = scandir($dir);

	foreach ($contents as $item) {
		if ($item != '.' && $item != '..') {
			$path = $dir . '/' . $item;

			if (is_dir($path)) {
				chmod($path, $mode);
				chmodRecursive($path, $mode);
			} else {
				chmod($path, $mode);
			}
		}
	}

	return true;
}

// Функция для удаления содержимого каталога
function deleteDirectory (string $dir) {
	if (! is_dir($dir)) return false;

	$contents = scandir($dir);

	foreach ($contents as $item) {
		if ($item != '.' && $item != '..') {
			$path = $dir . '/' . $item;
			if (is_dir($path)) {
				deleteDirectory($path);
			} else {
				unlink($path);
			}
		}
	}

	return rmdir($dir);
}

/**
 * Додає файли та директорії з вказаного каталогу до ZIP архіву.
 *
 * Функція рекурсивно проходить через всі файли та підкаталоги вказаного каталогу
 * і додає їх до ZIP архіву, зберігаючи структуру директорій.
 *
 * @param string $dir Шлях до каталогу, файли якого потрібно додати до архіву.
 * @param ZipArchive $ZA Об'єкт ZipArchive, до якого будуть додані файли.
 * @param string $zipDir [optional] Шлях всередині архіву, куди будуть додані файли.
 *
 * @return void
 */
function addFilesToZip(string $dir, \ZipArchive $ZA, string $zipDir='') {
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			// Додаємо порожню директорію в архів
			if (!empty($zipDir)) $ZA->addEmptyDir($zipDir);

			while (($file = readdir($dh)) !== false) {
				if ($file != '.' && $file != '..') {
					$fullPath = $dir . '/' . $file;

					if (is_dir($fullPath)) {
						// Рекурсивно додаємо директорії
						addFilesToZip($fullPath . '/', $ZA, $zipDir . $file . '/');
					} else {
						// Додаємо файли в архів
						$ZA->addFile($fullPath, $zipDir . $file);
					}
				}
			}

			closedir($dh);
		}
	}
}

