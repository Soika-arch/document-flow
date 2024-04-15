<?php

// Загальні конфігурації застосунку.

const MainCssName = 'main';

const Debug = true;
const LogSql = true;

if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') define('Production', false);
else define('Production', true);

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
define('DirCron', DirRoot .'/cron');
define('DirCore', DirRoot .'/core');
define('DirControllers', DirCore .'/controllers');
define('DirModels', DirCore .'/models');
define('DirTraits', DirCore .'/traits');
define('DirViews', DirCore .'/views');

// namespaces.

define(
	'NamespaceControllers',
	str_replace('/', '\\', trim(str_replace(DirRoot, '', DirControllers), '/'))
);

// Ім'я контролера за замовчуванням.
define('DefaultControllerName', 'MainController');
// Ім'я екшена контролера за замовчуванням.
define('DefaultAction', 'mainAction');
define('NotFoundAction', 'notFoundAction');
// Ім'я класа контролера за замовчуванням.
define('DefaultControllerClassName', NamespaceControllers .'\\'. DefaultControllerName);

// URL повний.
define('URL', ServerProtocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// URL корня сайта.
define('URLHome', ServerProtocol . trim($_SERVER['HTTP_HOST'], '/'));
define('URI', ltrim($_SERVER['REQUEST_URI'], '/'));

require_once 'db.php';
require_once DirFunc .'/main.php';
require_once DirFunc .'/db.php';

// start_app();
classesAutoload();
