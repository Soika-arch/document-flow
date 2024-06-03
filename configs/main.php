<?php

// Загальні конфігурації застосунку.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

date_default_timezone_set('Europe/Kiev');

/** @var string Назва сайту. */
const SiteName = 'Електронний документообіг';
/** @var string Назва головного файлу css стилей. */
const MainCssName = 'main';
/** @var bool Чи треба контролювати максимальний час сесії користувача. */
const SessionTimeoutEnabled = false;
/** @var int Максимальний час сесії користувача в секундах після авторизації. */
const SessionTimeout = 3600;
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

/** @var string Каталог конфігів */
define('DirConfig', dirname(__FILE__));
/** @var string Корінь сайта */
define('DirRoot', dirname(DirConfig));
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
/** @var string Каталог модулів. */
define('DirModules', DirRoot .'/modules');

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

/** @var string URI модуля адмін-панелі. */
define('URIAdmin', 'ap');
/** @var string URI модуля cron-задач. */
define('URICron', 'cron');

// Визначення URI поточного модуля.

if ($pos = strpos(URIPath, '/')) {
	$URIModule = substr(URIPath, 0, $pos);
}
else {
	$URIModule = URIPath;
}

$dirModule = DirModules .'/'. $URIModule;

if (! is_dir($dirModule)) {
	$URIModule = '';
}

/** @var string URI поточного модуля. */
define('URIModule', $URIModule);
/** @var string URL поточного модуля. */
define('URLModule', URLHome .'/'. URIModule);

/** @var string ім'я екшена контролера за замовчуванням. */
define('DefaultPage', 'mainPage');
/** @var string ім'я екшена контролера сторінки page-not-found. */
define('NotFoundPage', 'notFoundPage');
/** @var string ім'я контролера за замовчуванням. */
define('DefaultControllerName', 'MainController');

$dName = str_replace([DirRoot, '/'], ['', '\\'], DirControllers);

/** @var string namespace контролерів за замовчуванням. */
define('DefaultControllerNamespace', $dName);

// Підключення загальних файлів застосунку.

require_once DirConfig .'/secrets.php';
require_once 'db.php';
require_once DirFunc .'/main.php';
require_once DirFunc .'/db.php';
require_once DirFunc .'/rg.php';
require_once DirFunc .'/rt.php';
require_once DirFunc .'/hd.php';
require_once DirFunc .'/sess.php';
require_once DirFunc .'/tm.php';
require_once DirFunc .'/msg.php';
require_once DirFunc .'/tg.php';
require_once DirFunc .'/db_users.php';
