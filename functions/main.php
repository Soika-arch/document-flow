<?php

// Головні функції проєкту.

// Автопідключення класів.

use core\Debug;
use core\Header;

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
				// dd([$fname, is_file($fname)], __FILE__, __LINE__,1);
			}
		}
	);

	define('PetamicrClassesAutoloader', true);
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
 * @return string
 */
function url (null|string $s=null, array $p=[]) {
	if (! is_null($s)) {
		if ($s === '') {
			$url = URLHome .'/';
		}
		else if (strpos($s, '/') === 0) {
			$url = trim(URLHome .'/'. trim($s, '/'), '/') .'/';
		}
		else {
			$url = URLHome .'/'. trim($s, '/') .'/';
		}
	}
	else $url = $_GET ? URL : URL .'/';

	return ($p === []) ? $url : urlSetParams($url, $p);
}

/**
 *
 */
function urlSetParams (string $url, array $p) {
	if ($p !== []) {
		$urlParts = parse_url($url);

		return $urlParts['scheme'] . '://' . $urlParts['host'] . rtrim($urlParts['path'], '/') . '/?'.
			http_build_query($p);
	}

	return $url;
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
function getPreviousClass (object $obj, string $endClass): string {
	// Отримання назви класу поточного об'єкта $obj.
	$currentClass = get_class($obj);
	// У подальшому дочірній клас відносно класу $currentClass.
	$previous = '';

	// Цикл виконується поки не дійде до класу $endClass.
	while ($currentClass !== $endClass) {
		$previous = $currentClass;
		$currentClass = get_parent_class($currentClass);
	}

	return $previous;
}
