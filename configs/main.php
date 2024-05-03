<?php

// Загальні конфігурації застосунку.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

date_default_timezone_set('Europe/Kiev');

/** @var string Назва сайту. */
const SiteName = 'Електронний документообіг';
/** @var string Назва головного файлу css стилей. */
const MainCssName = 'main';
/** @var string Назва головного файлу css стилей адмін-панелі. */
const AdminCssName = 'admin';
/** @var bool Чи треба контролювати максимальний час сесії користувача. */
const SessionTimeoutEnabled = false;
/** @var int Максимальний час сесії користувача в секундах після авторизації. */
const SessionTimeout = 900;
/** @var bool Чи треба відстежувати час бездіяльності користувача. */
const TrackUserActivity = true;
/** @var int Час максимальної бездіяльності користувача. */
const MaxIdleTime = 600;

/** @var bool Якщо true - сервіс працює в режимі дебага. */
const Debug = true;
/** @var bool Чи буде відбуватись логування sql-запитів. */
const LogSql = true;

if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
	/** @var bool Якщо ip-адреса поточного хоста = '127.0.0.1' - сайт працює в режимі розробки. */
	define('Production', false);
}
else {
	/** @var bool Якщо ip-адреса поточного хоста = '127.0.0.1' - сайт працює в режимі розробки. */
	define('Production', true);
}

/** @var array масив можливих http-протоколів, за якими може працювати сервіс. */
const Protocols = [
	'HTTP/1.1' => 'http://'
];

// Автоматичне визначення протоколу HTTP на якому працює сервер.

if (isset($_SERVER['SERVER_PROTOCOL'])) {
	/** @var string поточний HTTP протокол. */
	define('ServerProtocol', Protocols[$_SERVER['SERVER_PROTOCOL']]);
}
else {
	/** @var string поточний HTTP протокол. */
	define('ServerProtocol', 'http://');
}

// Визначення основних директорій проєкта.

/** @var string Корінь сайта */
define('DirRoot', dirname(dirname(__FILE__)));
/** @var string Каталог функцій. */
define('DirFunc', DirRoot .'/functions');
/** @var string Каталог для cron завдань. */
define('DirCron', DirRoot .'/cron');
/** @var string Каталог ядра застосунка. */
define('DirCore', DirRoot .'/core');
/** @var string Каталог контролерів. */
define('DirControllers', DirCore .'/controllers');
/** @var string Каталог моделей. */
define('DirModels', DirCore .'/models');
/** @var string Каталог трейтів. */
define('DirTraits', DirCore .'/traits');
/** @var string Каталог видів. */
define('DirViews', DirCore .'/views');

/** @var string повний поточний URL-запит. */
define('URL', ServerProtocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

$parsedURL = parse_url(URL);

/** @var URL корня сайта (http-протокол + хост). */
define('URLHome', ServerProtocol . $parsedURL['host']);
/** @var string поточний URI-запит (весь URL з параметрами, якщо вони є, але без URLHome). */
define('URI', ltrim($_SERVER['REQUEST_URI'], '/'));
/** @var string URI від хоста (не включно) до GET-параметрів (не включно). */
define('URIPath', trim($parsedURL['path'], '/'));

if (isset($parsedURL['query'])) {
	/** @var string повний рядок отриманих GET-параметрів. */
	define('URIParams', $parsedURL['query']);
}
else {
	/** @var string повний рядок отриманих GET-параметрів. */
	define('URIParams', '');
}

define('URIAdmin', 'ap');

/** @var array дані модулів сайта - ['uri' => [data]]. */
const Modules = [
	'' => [
		'name' => 'Main',
		'dirName' => '', // Назва відповідних каталогів ядра.
		'defaultControllerName' => 'MainController',
		'namespaceControllers' => 'core\controllers',
		'namespaceModels' => 'core\models',
	],
	URIAdmin => [
		'name' => 'Admin',
		'dirName' => 'admin', // Назва відповідних каталогів ядра.
		'defaultControllerName' => 'AdminController',
		'namespaceControllers' => 'core\controllers\admin',
		'namespaceModels' => 'core\models\admin',
	]
];

/** @var string ім'я екшена контролера за замовчуванням. */
define('DefaultPage', 'mainPage');
/** @var string ім'я екшена контролера сторінки page-not-found. */
define('NotFoundPage', 'notFoundPage');
define('DefaultControllerName', 'MainController');

// Підключення загальних файлів застосунку.

require_once 'db.php';
require_once DirFunc .'/main.php';
require_once DirFunc .'/db.php';
require_once DirFunc .'/rg.php';
require_once DirFunc .'/hd.php';
require_once DirFunc .'/sess.php';

classesAutoload();
