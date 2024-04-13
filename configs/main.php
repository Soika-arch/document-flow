<?php

// Загальні конфігурації застосунку.

const MainCssName = 'main';

const Debug = true;
const LogSql = true;

const Protocols = [
	'HTTP/1.1' => 'http://'
];

// Автоматичне визначення протоколу HTTP на якому працює сервер.

if (isset($_SERVER['SERVER_PROTOCOL'])) {
	define('ServerProtocol', Protocols[$_SERVER['SERVER_PROTOCOL']]);
}
else {
	define('ServerProtocol', 'http://');
}

// Корінь сайта.
define('DirRoot', dirname(dirname(__FILE__)));
define('DirFunc', DirRoot .'/functions');
define('DirClasses', DirRoot .'/classes');
define('DirCore', DirClasses .'/core');
define('DirCron', DirRoot .'/cron');
define('DirControllers', DirClasses .'/controllers');
define('DirModels', DirClasses .'/models');
define('DirTraits', DirClasses .'/traits');
define('DirViews', DirClasses .'/views');

// URL повний.
define('URL', ServerProtocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// URL корня сайта.
define('URLHome', ServerProtocol . trim($_SERVER['HTTP_HOST'], '/'));
define('URI', ltrim($_SERVER['REQUEST_URI'], '/'));

// Отримання імені контролера в URI.

if (strpos(URI, '?') !== false) {
	// URI запит має параметри.

	if (strpos(URI, '/') !== false) {
		define('ControllerName', substr(URI, 0, strpos(URI, '/')));
	}
	else {
		define('ControllerName', substr(URI, 0, strpos(URI, '?')));
	}
}
else {
	// URI запит НЕ має параметрів.

	if (strpos(URI, '/')) {
		define('ControllerName', substr(URI, 0, strpos(URI, '/')));
	}
	else {
		define('ControllerName', URI);
	}
}

require_once DirFunc .'/main.php';

// start_app();
classesAutoload();
