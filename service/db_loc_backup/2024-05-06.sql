-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 06 2024 г., 04:35
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
  `idr_id_user` int NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `idr_id_document_format` bigint UNSIGNED NOT NULL COMMENT 'Тип носія документа',
  `idr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Фізичне місцезнаходження оригінала',
  `idr_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер вхідного документа',
  `idr_outgoing_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Номер вихідного',
  `idr_id_title` bigint UNSIGNED NOT NULL COMMENT 'Назва чи заголовок документа',
  `idr_document_date` datetime DEFAULT NULL COMMENT 'Дата в документі',
  `idr_id_recipient` bigint NOT NULL COMMENT 'Отримувач (користувач)',
  `idr_id_sender` bigint UNSIGNED DEFAULT NULL COMMENT 'Відправник документу',
  `idr_date_received` date DEFAULT NULL COMMENT 'Дата отримання документа',
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
-- Структура таблицы `df_outgoing_documents_registry`
--

CREATE TABLE `df_outgoing_documents_registry` (
  `odr_id` bigint UNSIGNED NOT NULL,
  `odr_id_user` int NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `odr_id_document_format` bigint UNSIGNED NOT NULL COMMENT 'Тип носія документа',
  `odr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Фізичне місцезнаходження оригінала',
  `odr_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер вихідного документа',
  `odr_incoming_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Номер вхідного',
  `odr_registration_form_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Реєстраційний номер бланка',
  `odr_id_title` bigint UNSIGNED NOT NULL COMMENT 'Назва чи заголовок документа',
  `odr_document_date` datetime DEFAULT NULL COMMENT 'Дата в документі',
  `odr_id_sender` bigint UNSIGNED NOT NULL COMMENT 'Відправник (користувач)',
  `odr_id_recipient` bigint UNSIGNED DEFAULT NULL COMMENT 'Отримувач (зовнішний)',
  `odr_id_description` bigint UNSIGNED DEFAULT NULL COMMENT 'Опис або короткий зміст документа',
  `odr_file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Шлях до файлу документа',
  `odr_id_status` bigint UNSIGNED DEFAULT NULL COMMENT 'Статус документа (наприклад, "новий", "в обробці", "завершено")',
  `odr_id_assigned_user` bigint UNSIGNED DEFAULT NULL COMMENT 'Призначений користувач обробки документа.',
  `odr_execution control` enum('o','m','q','a') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Контроль виконання: one-time, monthly, quarterly, annually',
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
  `urs_id` bigint UNSIGNED NOT NULL,
  `urs_id_user` bigint UNSIGNED NOT NULL,
  `urs_id_status` bigint UNSIGNED NOT NULL,
  `urs_add_date` datetime NOT NULL,
  `urs_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Зв''язки користувачів з їх статусами';

--
-- Дамп данных таблицы `df_users_rel_statuses`
--

INSERT INTO `df_users_rel_statuses` (`urs_id`, `urs_id_user`, `urs_id_status`, `urs_add_date`, `urs_change_date`) VALUES
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
  `urd_id_departament` bigint NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Статуси користувачів';

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
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `df_departments`
--
ALTER TABLE `df_departments`
  ADD PRIMARY KEY (`dp_id`);

--
-- Индексы таблицы `df_document_descriptions`
--
ALTER TABLE `df_document_descriptions`
  ADD PRIMARY KEY (`dds_id`);

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
  ADD PRIMARY KEY (`idr_id`);

--
-- Индексы таблицы `df_outgoing_documents_registry`
--
ALTER TABLE `df_outgoing_documents_registry`
  ADD PRIMARY KEY (`odr_id`);

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
  ADD PRIMARY KEY (`urs_id`),
  ADD UNIQUE KEY `uni_1` (`urs_id_user`,`urs_id_status`);

--
-- Индексы таблицы `df_user_document_access`
--
ALTER TABLE `df_user_document_access`
  ADD PRIMARY KEY (`uda_id`);

--
-- Индексы таблицы `df_user_rel_departament`
--
ALTER TABLE `df_user_rel_departament`
  ADD PRIMARY KEY (`urd_id`);

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
-- AUTO_INCREMENT для таблицы `df_document_descriptions`
--
ALTER TABLE `df_document_descriptions`
  MODIFY `dds_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `urs_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `vr_id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
