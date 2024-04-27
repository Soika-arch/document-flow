<?php

// Загальні конфігурації застосунку.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

date_default_timezone_set('Europe/Kiev');

/** @var string Назва сайту. */
const SiteName = 'Електронний документообіг';
/** @var string Назва головного файлу css стилей. */
const MainCssName = 'main';
/** @var bool Чи треба контролювати максимальний час сесії користувача. */
const SessionTimeoutEnabled = true;
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

// Якщо ip-адреса поточного хоста = '127.0.0.1' - сайт працює в режимі розробки.
if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') define('Production', false);
else define('Production', true);

// Масив можливих http-протоколів, за якими може працювати сервіс.
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

// Визначення основних директорій проєкта.

define('DirRoot', dirname(dirname(__FILE__))); // Корінь сайта.
define('DirFunc', DirRoot .'/functions'); // Каталог функцій.
define('DirCron', DirRoot .'/cron'); // Каталог для cron завдань.
define('DirCore', DirRoot .'/core'); // Каталог ядра застосунка.
define('DirControllers', DirCore .'/controllers'); // Каталог контролерів.
define('DirModels', DirCore .'/models'); // Каталог моделей.
define('DirTraits', DirCore .'/traits'); // Каталог трейтів.
define('DirViews', DirCore .'/views'); // Каталог видів.

// Простори імен (namespaces).

define(
	'NamespaceControllers',
	str_replace('/', '\\', trim(str_replace(DirRoot, '', DirControllers), '/'))
);

define(
	'NamespaceModels',
	str_replace('/', '\\', trim(str_replace(DirRoot, '', DirModels), '/'))
);

/** @var string ім'я контролера за замовчуванням. */
define('DefaultControllerName', 'MainController');
// Ім'я екшена контролера за замовчуванням.
define('DefaultPage', 'mainPage');
// Ім'я екшена контролера сторінки page-not-found.
define('NotFoundPage', 'notFoundPage');
// Ім'я класа контролера за замовчуванням.
define('DefaultControllerClass', NamespaceControllers .'\\'. DefaultControllerName);
// Повний поточний URL-запит.
define('URL', ServerProtocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// URL корня сайта (http-протокол + хост).
define('URLHome', ServerProtocol . trim($_SERVER['HTTP_HOST'], '/'));
// Поточний URI-запит (весь URL з параметрами, якщо вони є, але без URLHome).
define('URI', ltrim($_SERVER['REQUEST_URI'], '/'));

// Підключення загальних файлів застосунку.

require_once 'db.php';
require_once DirFunc .'/main.php';
require_once DirFunc .'/db.php';
require_once DirFunc .'/rg.php';
require_once DirFunc .'/hd.php';

// start_app();
classesAutoload();
