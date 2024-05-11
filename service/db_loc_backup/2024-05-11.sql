-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 11 2024 г., 15:57
-- Версия сервера: 8.0.36-0ubuntu0.22.04.1
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `petamicr`
--

-- --------------------------------------------------------

--
-- Структура таблицы `df_departments`
--

CREATE TABLE `df_departments` (
  `dp_id` bigint UNSIGNED NOT NULL,
  `dp_id_user` bigint UNSIGNED NOT NULL,
  `dp_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Назва відділу',
  `dp_add_date` datetime NOT NULL,
  `dp_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Відділи організації';

-- --------------------------------------------------------

--
-- Структура таблицы `df_distribution_scopes`
--

CREATE TABLE `df_distribution_scopes` (
  `dsc_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_descriptions`
--

CREATE TABLE `df_document_descriptions` (
  `dds_id` bigint UNSIGNED NOT NULL,
  `dds_id_user` bigint NOT NULL,
  `dds_description` text COLLATE utf8mb4_unicode_ci,
  `dds_add_date` datetime NOT NULL,
  `dds_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Опис або короткий зміст документів';

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_formats`
--

CREATE TABLE `df_document_formats` (
  `dfm_id` bigint UNSIGNED NOT NULL,
  `dfm_id_user` bigint UNSIGNED NOT NULL,
  `dfm_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dfm_add_date` datetime NOT NULL,
  `dfm_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Можливі формати носіів документів';

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_locations`
--

CREATE TABLE `df_document_locations` (
  `dlc_id` bigint UNSIGNED NOT NULL,
  `dlc_id_user` bigint UNSIGNED NOT NULL,
  `dlc_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dlc_add_date` datetime NOT NULL,
  `dlc_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Назви місцезнаходжень оригіналів документів';

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_resolutions`
--

CREATE TABLE `df_document_resolutions` (
  `drs_id` bigint UNSIGNED NOT NULL,
  `drs_id_user` bigint UNSIGNED NOT NULL,
  `drs_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `drs_add_date` datetime NOT NULL,
  `drs_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Резолюції документів';

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_senders`
--

CREATE TABLE `df_document_senders` (
  `dss_id` bigint UNSIGNED NOT NULL,
  `dss_id_user` bigint UNSIGNED DEFAULT NULL,
  `dss_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Назва організації / ФІО',
  `dss_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dss_phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dss_address` text COLLATE utf8mb4_unicode_ci,
  `dss_legal_address` text COLLATE utf8mb4_unicode_ci COMMENT 'Юридична адреса',
  `dss_add_date` datetime NOT NULL,
  `dss_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Дані відправників документів';

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_statuses`
--

CREATE TABLE `df_document_statuses` (
  `dst_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Статуси документів (новий, в обробці ...)';

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_titles`
--

CREATE TABLE `df_document_titles` (
  `dts_id` bigint UNSIGNED NOT NULL,
  `dts_id_user` bigint UNSIGNED NOT NULL,
  `dts_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dts_add_date` datetime NOT NULL,
  `dts_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Назви або заголовоки документів';

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_types`
--

CREATE TABLE `df_document_types` (
  `dt_id` bigint UNSIGNED NOT NULL,
  `dt_id_user` bigint NOT NULL,
  `dt_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dt_description` text COLLATE utf8mb4_unicode_ci,
  `dt_add_date` datetime NOT NULL,
  `dt_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Типи документів';

--
-- Дамп данных таблицы `df_document_types`
--

INSERT INTO `df_document_types` (`dt_id`, `dt_id_user`, `dt_name`, `dt_description`, `dt_add_date`, `dt_change_date`) VALUES
(1, 1, 'Лист', 'Документ у формі листа', '2024-05-04 14:28:44', '2024-05-04 14:28:44'),
(2, 1, 'Службова записка', 'Документ у формі записки', '2024-05-04 14:30:36', '2024-05-04 14:30:36'),
(3, 1, 'Заява', 'Заява або запит', '2024-05-04 14:31:10', '2024-05-04 14:31:10'),
(4, 1, 'Протокол', 'Протокол наради', '2024-05-04 14:31:32', '2024-05-04 14:31:32');

-- --------------------------------------------------------

--
-- Структура таблицы `df_incoming_documents_registry`
--

CREATE TABLE `df_incoming_documents_registry` (
  `idr_id` bigint UNSIGNED NOT NULL,
  `idr_id_user` bigint UNSIGNED NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `idr_id_document_type` bigint UNSIGNED NOT NULL COMMENT 'Тип документа',
  `idr_id_document_format` bigint UNSIGNED NOT NULL COMMENT 'Тип носія документа',
  `idr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Фізичне місцезнаходження оригінала',
  `idr_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер вхідного документа',
  `idr_id_outgoing_number` bigint UNSIGNED DEFAULT NULL COMMENT 'Номер вихідного',
  `idr_id_title` bigint UNSIGNED NOT NULL COMMENT 'Назва чи заголовок документа',
  `idr_document_date` date DEFAULT NULL COMMENT 'Дата в документі',
  `idr_id_recipient` bigint UNSIGNED NOT NULL COMMENT 'Отримувач (користувач)',
  `idr_id_sender` bigint UNSIGNED DEFAULT NULL COMMENT 'Відправник документу (зовнішній)',
  `idr_id_description` bigint UNSIGNED DEFAULT NULL COMMENT 'Опис або короткий зміст документа',
  `idr_file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Шлях до файлу документа',
  `idr_id_status` bigint UNSIGNED DEFAULT NULL COMMENT 'Статус документа (наприклад, "новий", "в обробці", "завершено")',
  `idr_id_responsible_user` bigint UNSIGNED DEFAULT NULL COMMENT 'id відповідального за виконання',
  `idr_id_assigned_user` bigint UNSIGNED DEFAULT NULL COMMENT 'Призначений користувач обробки документа.',
  `idr_id_assigned_departament` bigint UNSIGNED DEFAULT NULL COMMENT 'id відділа, якому призначено на виконання',
  `idr_id_resolution` bigint UNSIGNED DEFAULT NULL COMMENT 'Резолюція',
  `idr_resolution_date` datetime DEFAULT NULL COMMENT 'Дата призначення резолюції',
  `idr_date_of_receipt_by_executor` datetime DEFAULT NULL COMMENT 'Дата надходження виконавцю',
  `idr_execution control` enum('o','m','q','a') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Контроль виконання: one-time, monthly, quarterly, annually',
  `idr_control_date` datetime NOT NULL COMMENT 'Дата, до якої документ має бути виконаним',
  `idr_execution_date` datetime DEFAULT NULL COMMENT 'Дата виконання документа',
  `idr_add_date` datetime NOT NULL,
  `idr_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Регістр вхідних документів із основними даними';

-- --------------------------------------------------------

--
-- Структура таблицы `df_internal_documents_registry`
--

CREATE TABLE `df_internal_documents_registry` (
  `inr_id` bigint UNSIGNED NOT NULL,
  `inr_id_user` int NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `inr_id_document_type` bigint UNSIGNED NOT NULL COMMENT 'Тип документа',
  `inr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Фізичне місцезнаходження оригінала',
  `inr_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер документа',
  `inr_additional_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Додатковий номер',
  `inr_id_title` bigint UNSIGNED NOT NULL COMMENT 'Назва чи заголовок документа',
  `inr_document_date` datetime DEFAULT NULL COMMENT 'Дата в документі',
  `inr_id_initiator` bigint UNSIGNED NOT NULL COMMENT 'Ініціатор (користувач)',
  `inr_id_recipient` bigint UNSIGNED DEFAULT NULL COMMENT 'Отримувач (користувач)',
  `inr_id_description` bigint UNSIGNED DEFAULT NULL COMMENT 'Опис або короткий зміст документа',
  `inr_file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Шлях до файлу документа',
  `inr_id_status` bigint UNSIGNED DEFAULT NULL COMMENT 'Статус документа (наприклад, "новий", "в обробці", "завершено")',
  `inr_id_responsible_user` bigint UNSIGNED NOT NULL COMMENT 'id відповідального за виконання',
  `inr_id_assigned_departament` bigint UNSIGNED NOT NULL COMMENT 'id відділа, якому призначено на виконання',
  `inr_id_assigned_user` bigint UNSIGNED DEFAULT NULL COMMENT 'Призначений користувач обробки документа.',
  `inr_date_of_receipt_by_executor` bigint UNSIGNED DEFAULT NULL COMMENT 'Дата надходження виконавцю',
  `inr_execution control` enum('o','m','q','a') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Контроль виконання: one-time, monthly, quarterly, annually',
  `inr_control_date` datetime DEFAULT NULL COMMENT 'Дата, до якої документ має бути виконаним',
  `inr_execution_date` datetime DEFAULT NULL COMMENT 'Дата виконання документа',
  `inr_distribution_scope` bigint UNSIGNED NOT NULL COMMENT 'Поширюється на',
  `inr_add_date` datetime NOT NULL,
  `inr_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Регістр вихідних документів із основними даними';

-- --------------------------------------------------------

--
-- Структура таблицы `df_outgoing_documents_registry`
--

CREATE TABLE `df_outgoing_documents_registry` (
  `odr_id` bigint UNSIGNED NOT NULL,
  `odr_id_user` bigint UNSIGNED NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `odr_id_document_type` bigint UNSIGNED NOT NULL COMMENT 'Тип документа',
  `odr_id_document_format` bigint UNSIGNED NOT NULL COMMENT 'Тип носія документа',
  `odr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Фізичне місцезнаходження оригінала',
  `odr_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер вихідного документа',
  `odr_id_incoming_number` bigint UNSIGNED DEFAULT NULL COMMENT 'Номер вхідного',
  `odr_registration_form_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Реєстраційний номер бланка',
  `odr_id_title` bigint UNSIGNED NOT NULL COMMENT 'Назва чи заголовок документа',
  `odr_document_date` date DEFAULT NULL COMMENT 'Дата в документі',
  `odr_id_sender` bigint UNSIGNED NOT NULL COMMENT 'Відправник (користувач)',
  `odr_id_recipient` bigint UNSIGNED DEFAULT NULL COMMENT 'Отримувач (зовнішний)',
  `odr_id_description` bigint UNSIGNED DEFAULT NULL COMMENT 'Опис або короткий зміст документа',
  `odr_file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Шлях до файлу документа',
  `odr_id_status` bigint UNSIGNED DEFAULT NULL COMMENT 'Статус документа (наприклад, "новий", "в обробці", "завершено")',
  `odr_id_assigned_user` bigint UNSIGNED DEFAULT NULL COMMENT 'Призначений користувач обробки документа.',
  `odr_execution control` enum('o','m','q','a') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Контроль виконання: one-time, monthly, quarterly, annually',
  `odr_control_date` datetime DEFAULT NULL COMMENT 'Дата, до якої документ має бути виконаним',
  `odr_execution_date` datetime DEFAULT NULL COMMENT 'Дата виконання документа',
  `odr_add_date` datetime NOT NULL,
  `odr_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Регістр вихідних документів із основними даними';

-- --------------------------------------------------------

--
-- Структура таблицы `df_users`
--

CREATE TABLE `df_users` (
  `us_id` bigint UNSIGNED NOT NULL,
  `us_login` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `us_password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `us_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `us_add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `df_users`
--

INSERT INTO `df_users` (`us_id`, `us_login`, `us_password_hash`, `us_email`, `us_add_date`) VALUES
(0, 'Guest', '', '', '2024-04-14 16:05:13'),
(1, 'Admin', '$2y$10$vEIigCI0EotxwtiXyhE8V.fTo6CgjQhhK78zPWlYwm8XV17WTdkYu', '', '2024-04-14 16:05:13');

-- --------------------------------------------------------

--
-- Структура таблицы `df_users_rel_statuses`
--

CREATE TABLE `df_users_rel_statuses` (
  `usr_id` bigint UNSIGNED NOT NULL,
  `usr_id_user` bigint UNSIGNED NOT NULL,
  `usr_id_status` bigint UNSIGNED NOT NULL,
  `usr_add_date` datetime NOT NULL,
  `usr_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Зв''язки користувачів з їх статусами';

--
-- Дамп данных таблицы `df_users_rel_statuses`
--

INSERT INTO `df_users_rel_statuses` (`usr_id`, `usr_id_user`, `usr_id_status`, `usr_add_date`, `usr_change_date`) VALUES
(1, 1, 1, '2024-04-24 19:30:41', '2024-04-24 19:30:41'),
(2, 0, 5, '2024-04-24 19:32:45', '2024-04-24 19:32:45');

-- --------------------------------------------------------

--
-- Структура таблицы `df_user_document_access`
--

CREATE TABLE `df_user_document_access` (
  `uda_id` bigint UNSIGNED NOT NULL,
  `uda_id_user` bigint UNSIGNED NOT NULL COMMENT 'Користувач, який надав доступ',
  `uda_id_recipient` bigint UNSIGNED NOT NULL,
  `uda_id_document` bigint UNSIGNED NOT NULL,
  `uda_add_date` datetime NOT NULL,
  `uda_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Таблиця доступу до документів користувачів';

-- --------------------------------------------------------

--
-- Структура таблицы `df_user_rel_departament`
--

CREATE TABLE `df_user_rel_departament` (
  `urd_id` bigint UNSIGNED NOT NULL,
  `urd_id_user` bigint UNSIGNED NOT NULL,
  `urd_id_departament` bigint UNSIGNED NOT NULL,
  `urd_add_date` datetime NOT NULL,
  `urd_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Зв''язки користувачів з департаментами';

-- --------------------------------------------------------

--
-- Структура таблицы `df_user_statuses`
--

CREATE TABLE `df_user_statuses` (
  `uss_id` bigint UNSIGNED NOT NULL,
  `uss_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uss_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uss_access_level` tinyint NOT NULL COMMENT 'Числовий рівень доступу',
  `uss_add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Статуси користувачів модуля df_';

--
-- Дамп данных таблицы `df_user_statuses`
--

INSERT INTO `df_user_statuses` (`uss_id`, `uss_name`, `uss_description`, `uss_access_level`, `uss_add_date`) VALUES
(1, 'SuperAdmin', 'Супер адміністратор', 1, '2024-05-04 14:45:11'),
(2, 'Admin', 'Адміністратор', 2, '2024-04-24 19:29:50'),
(3, 'User', 'Користувач', 3, '2024-05-04 14:42:53'),
(4, 'Viewer', 'Переглядач', 4, '2024-05-04 14:44:17'),
(5, 'Guest', 'Гість', 5, '2024-04-24 19:32:08');

-- --------------------------------------------------------

--
-- Структура таблицы `df_visitor_routes`
--

CREATE TABLE `df_visitor_routes` (
  `vr_id` int UNSIGNED NOT NULL,
  `vr_id_user` bigint UNSIGNED NOT NULL,
  `vr_ip` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vr_uri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vr_user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vr_queries_count` int UNSIGNED DEFAULT NULL COMMENT 'Количество запросов к БД. при посещении URI.',
  `vr_execution_time` float UNSIGNED NOT NULL COMMENT 'Час повного виконання URL запиту користувача в секундах з точністю до міліонних',
  `vr_add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `df_visitor_routes`
--

INSERT INTO `df_visitor_routes` (`vr_id`, `vr_id_user`, `vr_ip`, `vr_uri`, `vr_user_agent`, `vr_queries_count`, `vr_execution_time`, `vr_add_date`) VALUES
(1, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 07:39:10'),
(2, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 07:39:53'),
(3, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 07:44:24'),
(4, 0, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.05019, '2024-05-06 12:36:02'),
(5, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01105, '2024-05-06 12:36:04'),
(6, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:36:09'),
(7, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00716, '2024-05-06 12:36:09'),
(8, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01222, '2024-05-06 12:36:11'),
(9, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01414, '2024-05-06 12:36:11'),
(10, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:36:13'),
(11, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:37:32'),
(12, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:41:37'),
(13, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:43:22'),
(14, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:43:30'),
(15, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:43:31'),
(16, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:44:46'),
(17, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:46:25'),
(18, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:47:58'),
(19, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:48:07'),
(20, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:48:16'),
(21, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:49:26'),
(22, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:49:48'),
(23, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:49:55'),
(24, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:50:10'),
(25, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:50:50'),
(26, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:52:23'),
(27, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:52:32'),
(28, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 12:57:10'),
(29, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 13:02:57'),
(30, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 13:04:43'),
(31, 0, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.04298, '2024-05-06 14:23:53'),
(32, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01237, '2024-05-06 14:24:59'),
(33, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:25:01'),
(34, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00786, '2024-05-06 14:25:02'),
(35, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01168, '2024-05-06 14:25:03'),
(36, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01451, '2024-05-06 14:25:04'),
(37, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:25:05'),
(38, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:25:39'),
(39, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:26:02'),
(40, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:26:10'),
(41, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:26:39'),
(42, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:28:08'),
(43, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:37:43'),
(44, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:38:01'),
(45, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:38:46'),
(46, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:40:48'),
(47, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:53:29'),
(48, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 14:53:40'),
(49, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:09:09'),
(50, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:09:52'),
(51, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:18:53'),
(52, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:19:49'),
(53, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:26:29'),
(54, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:27:11'),
(55, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:28:16'),
(56, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:28:20'),
(57, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:28:27'),
(58, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:29:20'),
(59, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:41:59'),
(60, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:42:59'),
(61, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:43:14'),
(62, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:44:03'),
(63, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 15:44:39'),
(64, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 16:03:10'),
(65, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 16:24:38'),
(66, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 16:41:19'),
(67, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 16:41:51'),
(68, 0, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.02698, '2024-05-06 17:16:56'),
(69, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00789, '2024-05-06 17:16:58'),
(70, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:17:01'),
(71, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00612, '2024-05-06 17:17:01'),
(72, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00949, '2024-05-06 17:17:02'),
(73, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01142, '2024-05-06 17:17:03'),
(74, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:17:04'),
(75, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:18:25'),
(76, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:18:29'),
(77, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:19:27'),
(78, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:20:06'),
(79, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:23:05'),
(80, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:23:39'),
(81, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:24:07'),
(82, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:25:16'),
(83, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:25:28'),
(84, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:25:29'),
(85, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:25:59'),
(86, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:26:10'),
(87, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:26:47'),
(88, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:32:01'),
(89, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:33:24'),
(90, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:33:29'),
(91, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:33:34'),
(92, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:33:39'),
(93, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:33:48'),
(94, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:33:52'),
(95, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 17:46:30'),
(96, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 18:21:52'),
(97, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 18:22:27'),
(98, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 18:24:09'),
(99, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 18:24:28'),
(100, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 18:24:54'),
(101, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:02:34'),
(102, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:03:21'),
(103, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:03:34'),
(104, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:04:09'),
(105, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:05:55'),
(106, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:10:05'),
(107, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:10:34'),
(108, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:10:36'),
(109, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:10:37'),
(110, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:10:55'),
(111, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:12:16'),
(112, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:13:22'),
(113, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:14:23'),
(114, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:14:36'),
(115, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:15:04'),
(116, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:15:41'),
(117, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:15:56'),
(118, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:16:21'),
(119, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:18:27'),
(120, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:20:02'),
(121, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:20:11'),
(122, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:20:22'),
(123, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:22:40'),
(124, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:22:53'),
(125, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:23:51'),
(126, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:23:58'),
(127, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:24:42'),
(128, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:26:34'),
(129, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:26:43'),
(130, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:26:49'),
(131, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:26:57'),
(132, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:27:01'),
(133, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:27:06'),
(134, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:27:57'),
(135, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:30:15'),
(136, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:30:32'),
(137, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:33:49'),
(138, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:34:54'),
(139, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:37:23'),
(140, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:37:31'),
(141, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:37:56'),
(142, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:38:07'),
(143, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:38:35'),
(144, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:39:26'),
(145, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:39:57'),
(146, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:40:18'),
(147, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:41:04'),
(148, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:41:37'),
(149, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:42:05'),
(150, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:42:18'),
(151, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:42:27'),
(152, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:42:32'),
(153, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:43:42'),
(154, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:43:49'),
(155, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:44:06'),
(156, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:44:17'),
(157, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:44:23'),
(158, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:44:28'),
(159, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:44:33'),
(160, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:45:09'),
(161, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:45:19'),
(162, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:45:26'),
(163, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:46:41'),
(164, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:46:49'),
(165, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:46:57'),
(166, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-06 19:47:17'),
(167, 0, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.07835, '2024-05-08 16:25:00'),
(168, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.0121, '2024-05-08 16:25:02'),
(169, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 16:25:04'),
(170, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00783, '2024-05-08 16:25:04'),
(171, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01197, '2024-05-08 16:25:07'),
(172, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 16:26:58'),
(173, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 16:27:23'),
(174, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 16:27:32'),
(175, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 16:28:37'),
(176, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 16:29:15'),
(177, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01029, '2024-05-08 16:29:58'),
(178, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 16:41:00'),
(179, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 5, 0.00511, '2024-05-08 16:41:00'),
(180, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00784, '2024-05-08 16:41:00'),
(181, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 16:41:03'),
(182, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00725, '2024-05-08 16:41:03'),
(183, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01502, '2024-05-08 16:41:05'),
(184, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01201, '2024-05-08 16:48:26'),
(185, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:18:12'),
(186, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:19:59'),
(187, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:20:14'),
(188, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:20:21'),
(189, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:38:48'),
(190, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:45:28'),
(191, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:46:12'),
(192, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:46:37'),
(193, 1, '127.0.0.1', 'ap/dfd', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:46:44'),
(194, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:46:47'),
(195, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:46:53'),
(196, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:47:18'),
(197, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:48:04'),
(198, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:48:47'),
(199, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:50:16'),
(200, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:51:44'),
(201, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:52:16'),
(202, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:53:15'),
(203, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:55:40'),
(204, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 17:56:19'),
(205, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:11:08'),
(206, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:11:50'),
(207, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:12:37'),
(208, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:18:08'),
(209, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:20:19'),
(210, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:24:15'),
(211, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:26:33'),
(212, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:27:15'),
(213, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:29:27'),
(214, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:29:55'),
(215, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:31:41'),
(216, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:37:00'),
(217, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:38:02'),
(218, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:38:28'),
(219, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:39:14'),
(220, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:39:20'),
(221, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:40:13'),
(222, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:41:04'),
(223, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:42:12'),
(224, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:44:16'),
(225, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:45:47'),
(226, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:46:29'),
(227, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 5, 0.00556, '2024-05-08 18:46:29'),
(228, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00597, '2024-05-08 18:46:29'),
(229, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:46:42'),
(230, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00676, '2024-05-08 18:46:42'),
(231, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01073, '2024-05-08 18:46:45'),
(232, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01484, '2024-05-08 18:47:04'),
(233, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:47:05'),
(234, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:48:51'),
(235, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:53:07'),
(236, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 18:54:05'),
(237, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:00:15'),
(238, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:02:43'),
(239, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:03:11'),
(240, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:03:12'),
(241, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:03:19'),
(242, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:03:20'),
(243, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:03:47'),
(244, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:03:59'),
(245, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:04:27'),
(246, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:04:38'),
(247, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 5, 0.0052, '2024-05-08 19:04:38'),
(248, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:04:38'),
(249, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01006, '2024-05-08 19:07:36'),
(250, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01032, '2024-05-08 19:07:52'),
(251, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:08:13'),
(252, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.0063, '2024-05-08 19:08:13'),
(253, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01146, '2024-05-08 19:08:14'),
(254, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01318, '2024-05-08 19:08:15'),
(255, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:08:17'),
(256, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.02959, '2024-05-08 19:08:21'),
(257, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01088, '2024-05-08 19:09:17'),
(258, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 5, 0.0089, '2024-05-08 19:09:18'),
(259, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00735, '2024-05-08 19:09:18'),
(260, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:09:21'),
(261, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00654, '2024-05-08 19:09:21'),
(262, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01278, '2024-05-08 19:09:23'),
(263, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01516, '2024-05-08 19:09:24'),
(264, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:09:25'),
(265, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01005, '2024-05-08 19:19:02'),
(266, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00831, '2024-05-08 19:19:04'),
(267, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01023, '2024-05-08 19:19:05'),
(268, 1, '127.0.0.1', 'ap/users/add', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 10, 0.01163, '2024-05-08 19:19:06'),
(269, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.0323, '2024-05-08 19:19:48'),
(270, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:19:50'),
(271, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01305, '2024-05-08 19:19:52'),
(272, 1, '127.0.0.1', 'ap/users/add', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 10, 0.00989, '2024-05-08 19:19:54'),
(273, 1, '127.0.0.1', 'ap/users/add', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:56:58'),
(274, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 5, 0.00548, '2024-05-08 19:56:58'),
(275, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00686, '2024-05-08 19:56:58'),
(276, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:57:01'),
(277, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00639, '2024-05-08 19:57:01'),
(278, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01014, '2024-05-08 19:57:02'),
(279, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.0153, '2024-05-08 19:57:11'),
(280, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 19:57:13'),
(281, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01184, '2024-05-08 19:57:15'),
(282, 1, '127.0.0.1', 'ap/users/add', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 10, 0.01033, '2024-05-08 19:57:16'),
(283, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01182, '2024-05-08 20:00:44'),
(284, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 20:00:46'),
(285, 0, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01081, '2024-05-08 20:58:58'),
(286, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00957, '2024-05-08 20:59:01'),
(287, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 20:59:03'),
(288, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00624, '2024-05-08 20:59:03'),
(289, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.0127, '2024-05-08 20:59:04'),
(290, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01616, '2024-05-08 20:59:05'),
(291, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-08 20:59:06'),
(292, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.08077, '2024-05-10 16:57:27'),
(293, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 16:57:42'),
(294, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00673, '2024-05-10 16:57:42'),
(295, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01554, '2024-05-10 16:57:44');
INSERT INTO `df_visitor_routes` (`vr_id`, `vr_id_user`, `vr_ip`, `vr_uri`, `vr_user_agent`, `vr_queries_count`, `vr_execution_time`, `vr_add_date`) VALUES
(296, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01465, '2024-05-10 16:57:55'),
(297, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 16:58:03'),
(298, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 17:16:11'),
(299, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 17:16:42'),
(300, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 17:42:18'),
(301, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 17:43:13'),
(302, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 17:45:11'),
(303, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 17:47:34'),
(304, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 17:56:10'),
(305, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 17:56:40'),
(306, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 17:58:06'),
(307, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 17:58:15'),
(308, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:29:33'),
(309, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:35:04'),
(310, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:36:03'),
(311, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:36:40'),
(312, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:36:59'),
(313, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:38:50'),
(314, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:38:58'),
(315, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:40:54'),
(316, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:44:18'),
(317, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:52:16'),
(318, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:52:27'),
(319, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:52:41'),
(320, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:53:10'),
(321, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:55:15'),
(322, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:55:26'),
(323, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:56:12'),
(324, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:57:29'),
(325, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:59:09'),
(326, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 18:59:41'),
(327, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 19:00:15'),
(328, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 19:01:27'),
(329, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 19:01:44'),
(330, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 19:02:15'),
(331, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 19:02:21'),
(332, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 19:04:09'),
(333, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-10 19:05:04'),
(334, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.04168, '2024-05-11 10:14:25'),
(335, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 10:14:28'),
(336, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00733, '2024-05-11 10:14:28'),
(337, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01548, '2024-05-11 10:14:30'),
(338, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01229, '2024-05-11 10:14:31'),
(339, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 10:14:32'),
(340, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 10:17:20'),
(341, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 10:53:12'),
(342, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.04645, '2024-05-11 13:15:55'),
(343, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 13:15:59'),
(344, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00739, '2024-05-11 13:15:59'),
(345, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01498, '2024-05-11 13:16:00'),
(346, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01434, '2024-05-11 13:16:01'),
(347, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 13:16:02'),
(348, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 13:34:14'),
(349, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 13:37:00'),
(350, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 13:40:58'),
(351, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 13:41:13'),
(352, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 13:43:05'),
(353, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 5, 0.00567, '2024-05-11 13:43:05'),
(354, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00683, '2024-05-11 13:43:05'),
(355, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 13:43:16'),
(356, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00733, '2024-05-11 13:43:16'),
(357, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01121, '2024-05-11 13:43:17'),
(358, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01564, '2024-05-11 13:43:18'),
(359, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 13, 0.0114, '2024-05-11 13:43:19'),
(360, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 13:43:38'),
(361, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 14:06:18'),
(362, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 5, 0.00529, '2024-05-11 14:06:18'),
(363, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00647, '2024-05-11 14:06:18'),
(364, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 14:06:21'),
(365, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00722, '2024-05-11 14:06:21'),
(366, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00958, '2024-05-11 14:06:22'),
(367, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01216, '2024-05-11 14:06:22'),
(368, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 12, 0.01031, '2024-05-11 14:06:23'),
(369, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 14:07:02'),
(370, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 14:07:17'),
(371, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 14:08:25'),
(372, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 14:09:47'),
(373, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 14:11:02'),
(374, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 14:11:31'),
(375, 0, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01246, '2024-05-11 15:08:38'),
(376, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00781, '2024-05-11 15:08:42'),
(377, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:08:45'),
(378, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00639, '2024-05-11 15:08:45'),
(379, 1, '127.0.0.1', 'ap', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.01014, '2024-05-11 15:08:46'),
(380, 1, '127.0.0.1', 'ap/users', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 9, 0.00912, '2024-05-11 15:08:47'),
(381, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:08:48'),
(382, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:09:21'),
(383, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:09:39'),
(384, 1, '127.0.0.1', 'ap/users/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:10:47'),
(385, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:11:04'),
(386, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:12:34'),
(387, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:12:44'),
(388, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:20:46'),
(389, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:22:19'),
(390, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:24:41'),
(391, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:25:06'),
(392, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:30:12'),
(393, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:30:27'),
(394, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:35:52'),
(395, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:36:27'),
(396, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:36:34'),
(397, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:36:37'),
(398, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:36:54'),
(399, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:49:55'),
(400, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:50:54'),
(401, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:51:29'),
(402, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:51:55'),
(403, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:55:38'),
(404, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:56:01'),
(405, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:56:14'),
(406, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:56:33'),
(407, 1, '127.0.0.1', 'ap/users/list?pg=st', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:56:58'),
(408, 1, '127.0.0.1', 'ap/users/list?pg=23', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:57:17'),
(409, 1, '127.0.0.1', 'ap/users/list?pg=23', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:57:45'),
(410, 1, '127.0.0.1', 'ap/users/list?pg=23', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:58:01'),
(411, 1, '127.0.0.1', 'ap/users/list?pg=dr', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:58:07'),
(412, 1, '127.0.0.1', 'ap/users/list?pg=01', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:58:17'),
(413, 1, '127.0.0.1', 'ap/users/list?pg=01.3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:58:27'),
(414, 1, '127.0.0.1', 'ap/users/list?pg=01.3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:59:26'),
(415, 1, '127.0.0.1', 'ap/users/list?pg=01.', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:59:33'),
(416, 1, '127.0.0.1', 'ap/users/list?pg=01', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 15:59:36'),
(417, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:00:14'),
(418, 1, '127.0.0.1', 'ap/users/list?pg=01', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:00:59'),
(419, 1, '127.0.0.1', 'ap/users/list?pg=01', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:01:08'),
(420, 1, '127.0.0.1', 'ap/users/list?pg=01', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:14:41'),
(421, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:14:49'),
(422, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:15:16'),
(423, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:21:04'),
(424, 1, '127.0.0.1', 'ap/users/list?pg=01', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:21:10'),
(425, 1, '127.0.0.1', 'ap/users/list?pg=01.2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:21:16'),
(426, 1, '127.0.0.1', 'ap/users/list?pg=01,2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:21:23'),
(427, 1, '127.0.0.1', 'ap/users/list?pg=01,2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:21:50'),
(428, 1, '127.0.0.1', 'ap/users/list?pg=01,2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:22:26'),
(429, 1, '127.0.0.1', 'ap/users/list?pg=01,2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:23:33'),
(430, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:23:38'),
(431, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:24:05'),
(432, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:36:04'),
(433, 1, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 16:36:12'),
(434, 0, '127.0.0.1', 'ap/users/list?pg=1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 4, 0, '2024-05-11 18:55:35');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `df_departments`
--
ALTER TABLE `df_departments`
  ADD PRIMARY KEY (`dp_id`);

--
-- Индексы таблицы `df_distribution_scopes`
--
ALTER TABLE `df_distribution_scopes`
  ADD PRIMARY KEY (`dsc_id`);

--
-- Индексы таблицы `df_document_descriptions`
--
ALTER TABLE `df_document_descriptions`
  ADD PRIMARY KEY (`dds_id`);

--
-- Индексы таблицы `df_document_formats`
--
ALTER TABLE `df_document_formats`
  ADD PRIMARY KEY (`dfm_id`);

--
-- Индексы таблицы `df_document_locations`
--
ALTER TABLE `df_document_locations`
  ADD PRIMARY KEY (`dlc_id`);

--
-- Индексы таблицы `df_document_resolutions`
--
ALTER TABLE `df_document_resolutions`
  ADD PRIMARY KEY (`drs_id`);

--
-- Индексы таблицы `df_document_senders`
--
ALTER TABLE `df_document_senders`
  ADD PRIMARY KEY (`dss_id`);

--
-- Индексы таблицы `df_document_statuses`
--
ALTER TABLE `df_document_statuses`
  ADD PRIMARY KEY (`dst_id`);

--
-- Индексы таблицы `df_document_titles`
--
ALTER TABLE `df_document_titles`
  ADD PRIMARY KEY (`dts_id`);

--
-- Индексы таблицы `df_document_types`
--
ALTER TABLE `df_document_types`
  ADD PRIMARY KEY (`dt_id`);

--
-- Индексы таблицы `df_incoming_documents_registry`
--
ALTER TABLE `df_incoming_documents_registry`
  ADD PRIMARY KEY (`idr_id`),
  ADD UNIQUE KEY `uni_1` (`idr_number`),
  ADD KEY `idr_document_format` (`idr_id_document_format`),
  ADD KEY `idr_assigned_departament` (`idr_id_assigned_departament`),
  ADD KEY `idr_description` (`idr_id_description`),
  ADD KEY `idr_document_location` (`idr_id_document_location`),
  ADD KEY `idr_document_type` (`idr_id_document_type`),
  ADD KEY `idr_outgoing_number` (`idr_id_outgoing_number`),
  ADD KEY `idr_recipient` (`idr_id_recipient`),
  ADD KEY `idr_resolution` (`idr_id_resolution`),
  ADD KEY `idr_responsible_user` (`idr_id_responsible_user`),
  ADD KEY `idr_sender` (`idr_id_sender`),
  ADD KEY `idr_status` (`idr_id_status`),
  ADD KEY `idr_title` (`idr_id_title`),
  ADD KEY `idr_user` (`idr_id_user`);

--
-- Индексы таблицы `df_internal_documents_registry`
--
ALTER TABLE `df_internal_documents_registry`
  ADD PRIMARY KEY (`inr_id`),
  ADD UNIQUE KEY `uni_1` (`inr_number`);

--
-- Индексы таблицы `df_outgoing_documents_registry`
--
ALTER TABLE `df_outgoing_documents_registry`
  ADD PRIMARY KEY (`odr_id`),
  ADD UNIQUE KEY `uni_1` (`odr_number`);

--
-- Индексы таблицы `df_users`
--
ALTER TABLE `df_users`
  ADD PRIMARY KEY (`us_id`),
  ADD UNIQUE KEY `uni_1` (`us_login`);

--
-- Индексы таблицы `df_users_rel_statuses`
--
ALTER TABLE `df_users_rel_statuses`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `uni_1` (`usr_id_user`,`usr_id_status`),
  ADD KEY `usr_status` (`usr_id_status`);

--
-- Индексы таблицы `df_user_document_access`
--
ALTER TABLE `df_user_document_access`
  ADD PRIMARY KEY (`uda_id`);

--
-- Индексы таблицы `df_user_rel_departament`
--
ALTER TABLE `df_user_rel_departament`
  ADD PRIMARY KEY (`urd_id`),
  ADD KEY `urd_user` (`urd_id_user`),
  ADD KEY `urd_departament` (`urd_id_departament`);

--
-- Индексы таблицы `df_user_statuses`
--
ALTER TABLE `df_user_statuses`
  ADD PRIMARY KEY (`uss_id`),
  ADD UNIQUE KEY `uni_1` (`uss_name`);

--
-- Индексы таблицы `df_visitor_routes`
--
ALTER TABLE `df_visitor_routes`
  ADD PRIMARY KEY (`vr_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `df_departments`
--
ALTER TABLE `df_departments`
  MODIFY `dp_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_distribution_scopes`
--
ALTER TABLE `df_distribution_scopes`
  MODIFY `dsc_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_descriptions`
--
ALTER TABLE `df_document_descriptions`
  MODIFY `dds_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_formats`
--
ALTER TABLE `df_document_formats`
  MODIFY `dfm_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_locations`
--
ALTER TABLE `df_document_locations`
  MODIFY `dlc_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_resolutions`
--
ALTER TABLE `df_document_resolutions`
  MODIFY `drs_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_senders`
--
ALTER TABLE `df_document_senders`
  MODIFY `dss_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_statuses`
--
ALTER TABLE `df_document_statuses`
  MODIFY `dst_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_titles`
--
ALTER TABLE `df_document_titles`
  MODIFY `dts_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_types`
--
ALTER TABLE `df_document_types`
  MODIFY `dt_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `df_incoming_documents_registry`
--
ALTER TABLE `df_incoming_documents_registry`
  MODIFY `idr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_internal_documents_registry`
--
ALTER TABLE `df_internal_documents_registry`
  MODIFY `inr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_outgoing_documents_registry`
--
ALTER TABLE `df_outgoing_documents_registry`
  MODIFY `odr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_users`
--
ALTER TABLE `df_users`
  MODIFY `us_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблицы `df_users_rel_statuses`
--
ALTER TABLE `df_users_rel_statuses`
  MODIFY `usr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `df_user_document_access`
--
ALTER TABLE `df_user_document_access`
  MODIFY `uda_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_user_rel_departament`
--
ALTER TABLE `df_user_rel_departament`
  MODIFY `urd_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_user_statuses`
--
ALTER TABLE `df_user_statuses`
  MODIFY `uss_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `df_visitor_routes`
--
ALTER TABLE `df_visitor_routes`
  MODIFY `vr_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=435;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `df_incoming_documents_registry`
--
ALTER TABLE `df_incoming_documents_registry`
  ADD CONSTRAINT `idr_assigned_departament` FOREIGN KEY (`idr_id_assigned_departament`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_assigned_user` FOREIGN KEY (`idr_id_description`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_description` FOREIGN KEY (`idr_id_description`) REFERENCES `df_document_descriptions` (`dds_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_document_format` FOREIGN KEY (`idr_id_document_format`) REFERENCES `df_document_formats` (`dfm_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_document_location` FOREIGN KEY (`idr_id_document_location`) REFERENCES `df_document_locations` (`dlc_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_document_type` FOREIGN KEY (`idr_id_document_type`) REFERENCES `df_document_types` (`dt_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_outgoing_number` FOREIGN KEY (`idr_id_outgoing_number`) REFERENCES `df_outgoing_documents_registry` (`odr_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_recipient` FOREIGN KEY (`idr_id_recipient`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_resolution` FOREIGN KEY (`idr_id_resolution`) REFERENCES `df_document_resolutions` (`drs_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_responsible_user` FOREIGN KEY (`idr_id_responsible_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_sender` FOREIGN KEY (`idr_id_sender`) REFERENCES `df_document_senders` (`dss_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_status` FOREIGN KEY (`idr_id_status`) REFERENCES `df_document_statuses` (`dst_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_title` FOREIGN KEY (`idr_id_title`) REFERENCES `df_document_titles` (`dts_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_user` FOREIGN KEY (`idr_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_users_rel_statuses`
--
ALTER TABLE `df_users_rel_statuses`
  ADD CONSTRAINT `usr_status` FOREIGN KEY (`usr_id_status`) REFERENCES `df_user_statuses` (`uss_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `usr_user` FOREIGN KEY (`usr_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_user_rel_departament`
--
ALTER TABLE `df_user_rel_departament`
  ADD CONSTRAINT `urd_departament` FOREIGN KEY (`urd_id_departament`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `urd_user` FOREIGN KEY (`urd_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
