-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 10 2024 г., 18:17
-- Версия сервера: 8.0.36-0ubuntu0.22.04.1
-- Версия PHP: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- База данных: `petamicr`
--

-- --------------------------------------------------------

--
-- Структура таблицы `df_cron_tasks`
--

CREATE TABLE `df_cron_tasks` (
  `crt_id` bigint UNSIGNED NOT NULL,
  `crt_task_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crt_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `crt_schedule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Унікальний розклад у форматі cron',
  `crt_is_active` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL,
  `crt_last_run` datetime DEFAULT NULL,
  `crt_next_run` datetime DEFAULT NULL,
  `crt_parameters` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crt_add_date` datetime NOT NULL,
  `crt_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Конфігурації cron задач';

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
-- Структура таблицы `df_document_carrier_types`
--

CREATE TABLE `df_document_carrier_types` (
  `cts_id` bigint UNSIGNED NOT NULL,
  `cts_id_user` bigint UNSIGNED NOT NULL,
  `cts_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cts_add_date` datetime NOT NULL,
  `cts_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Можливі типи носіів документів';

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_control_types`
--

CREATE TABLE `df_document_control_types` (
  `dct_id` bigint UNSIGNED NOT NULL,
  `dct_id_user` bigint UNSIGNED NOT NULL,
  `dct_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dct_seconds` bigint UNSIGNED NOT NULL COMMENT 'Кількість секунд до дати контролю',
  `dct_add_date` datetime NOT NULL,
  `dct_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Видів контролю за виконанням документів';

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_descriptions`
--

CREATE TABLE `df_document_descriptions` (
  `dds_id` bigint UNSIGNED NOT NULL,
  `dds_id_user` bigint UNSIGNED NOT NULL,
  `dds_description` text COLLATE utf8mb4_unicode_ci,
  `dds_add_date` datetime NOT NULL,
  `dds_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Опис або короткий зміст документів';

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
  `dss_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Назва організації / ФІО',
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
  `dst_id` bigint UNSIGNED NOT NULL,
  `dst_id_user` bigint UNSIGNED NOT NULL COMMENT 'Користовач, який створив статус',
  `dst_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dst_add_date` datetime NOT NULL,
  `dst_change_date` datetime NOT NULL
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
  `dt_id_user` bigint UNSIGNED NOT NULL,
  `dt_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dt_description` text COLLATE utf8mb4_unicode_ci,
  `dt_add_date` datetime NOT NULL,
  `dt_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Типи документів';

-- --------------------------------------------------------

--
-- Структура таблицы `df_incoming_documents_registry`
--

CREATE TABLE `df_incoming_documents_registry` (
  `idr_id` bigint UNSIGNED NOT NULL,
  `idr_id_user` bigint UNSIGNED NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `idr_id_document_type` bigint UNSIGNED NOT NULL COMMENT 'Тип документа',
  `idr_id_carrier_type` bigint UNSIGNED NOT NULL COMMENT 'Тип носія документа',
  `idr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Відділ фізичного місцезнаходження оригінала',
  `idr_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер вхідного документа',
  `idr_id_outgoing_number` bigint UNSIGNED DEFAULT NULL COMMENT 'Номер відповідного вихідного',
  `idr_id_title` bigint UNSIGNED NOT NULL COMMENT 'Назва чи заголовок документа',
  `idr_document_date` date DEFAULT NULL COMMENT 'Дата в документі',
  `idr_id_recipient` bigint UNSIGNED DEFAULT NULL COMMENT 'Отримувач (користувач)',
  `idr_id_sender` bigint UNSIGNED DEFAULT NULL COMMENT 'Відправник документу (зовнішній)',
  `idr_id_description` bigint UNSIGNED DEFAULT NULL COMMENT 'Опис або короткий зміст документа',
  `idr_file_extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Розширення файлу завантаженого документа',
  `idr_id_status` bigint UNSIGNED DEFAULT NULL COMMENT 'Статус документа (наприклад, "новий", "в обробці", "завершено")',
  `idr_id_responsible_user` bigint UNSIGNED DEFAULT NULL COMMENT 'id відповідального за виконання',
  `idr_id_assigned_user` bigint UNSIGNED DEFAULT NULL COMMENT 'Призначений користувач обробки документа.',
  `idr_id_assigned_departament` bigint UNSIGNED DEFAULT NULL COMMENT 'id відділа, якому призначено на виконання',
  `idr_id_resolution` bigint UNSIGNED DEFAULT NULL COMMENT 'Резолюція',
  `idr_resolution_date` datetime DEFAULT NULL COMMENT 'Дата призначення резолюції',
  `idr_date_of_receipt_by_executor` datetime DEFAULT NULL COMMENT 'Дата надходження виконавцю',
  `idr_id_execution_control` bigint UNSIGNED DEFAULT NULL COMMENT 'Контроль виконання: one-time, monthly, quarterly, annually',
  `idr_id_term_of_execution` bigint UNSIGNED DEFAULT NULL COMMENT 'Термін виконання в днях',
  `idr_control_date` datetime DEFAULT NULL COMMENT 'Дата, до якої документ має бути виконаним',
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
  `inr_id_user` bigint UNSIGNED NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `inr_id_carrier_type` bigint UNSIGNED NOT NULL COMMENT 'Тип носія документа',
  `inr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Фізичне місцезнаходження оригінала',
  `inr_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер документа',
  `inr_additional_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Додатковий номер',
  `inr_id_document_type` bigint UNSIGNED NOT NULL COMMENT 'Тип документа',
  `inr_id_title` bigint UNSIGNED NOT NULL COMMENT 'Назва чи заголовок документа',
  `inr_document_date` date DEFAULT NULL COMMENT 'Дата в документі',
  `inr_id_initiator` bigint UNSIGNED NOT NULL COMMENT 'Ініціатор (користувач)',
  `inr_id_recipient` bigint UNSIGNED DEFAULT NULL COMMENT 'Отримувач (користувач)',
  `inr_id_description` bigint UNSIGNED DEFAULT NULL COMMENT 'Опис або короткий зміст документа',
  `inr_file_extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Розширення файлу завантаженого документа',
  `inr_id_status` bigint UNSIGNED DEFAULT NULL COMMENT 'Статус документа (наприклад, "новий", "в обробці", "завершено")',
  `inr_id_responsible_user` bigint UNSIGNED DEFAULT NULL COMMENT 'id відповідального за виконання',
  `inr_id_assigned_departament` bigint UNSIGNED DEFAULT NULL COMMENT 'id відділа, якому призначено на виконання',
  `inr_id_assigned_user` bigint UNSIGNED DEFAULT NULL COMMENT 'Призначений користувач обробки документа.',
  `inr_date_of_receipt_by_executor` datetime DEFAULT NULL COMMENT 'Дата надходження виконавцю',
  `inr_id_execution_control` bigint UNSIGNED DEFAULT NULL COMMENT 'Контроль виконання: one-time, monthly, quarterly, annually',
  `inr_id_term_of_execution` bigint UNSIGNED DEFAULT NULL COMMENT 'Термін виконання в днях',
  `inr_control_date` datetime DEFAULT NULL COMMENT 'Дата, до якої документ має бути виконаним',
  `inr_execution_date` datetime DEFAULT NULL COMMENT 'Дата виконання документа',
  `inr_distribution_scope` bigint UNSIGNED DEFAULT NULL COMMENT 'Поширюється на',
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
  `odr_id_carrier_type` bigint UNSIGNED NOT NULL COMMENT 'Тип носія документа',
  `odr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Фізичне місцезнаходження оригінала',
  `odr_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер вихідного документа',
  `odr_id_incoming_number` bigint UNSIGNED DEFAULT NULL COMMENT 'Номер відповідного вхідного',
  `odr_registration_form_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Реєстраційний номер бланка',
  `odr_id_title` bigint UNSIGNED NOT NULL COMMENT 'Назва чи заголовок документа',
  `odr_document_date` date DEFAULT NULL COMMENT 'Дата в документі',
  `odr_id_sender` bigint UNSIGNED NOT NULL COMMENT 'Відправник (користувач)',
  `odr_id_recipient` bigint UNSIGNED DEFAULT NULL COMMENT 'Отримувач (зовнішний)',
  `odr_id_description` bigint UNSIGNED DEFAULT NULL COMMENT 'Опис або короткий зміст документа',
  `odr_file_extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Розширення файлу завантаженого документа',
  `odr_id_status` bigint UNSIGNED DEFAULT NULL COMMENT 'Статус документа (наприклад, "новий", "в обробці", "завершено")',
  `odr_id_assigned_user` bigint UNSIGNED DEFAULT NULL COMMENT 'Призначений користувач обробки документа.',
  `odr_id_execution_control` bigint UNSIGNED DEFAULT NULL COMMENT 'Контроль виконання: one-time, monthly, quarterly, annually',
  `odr_control_date` datetime DEFAULT NULL COMMENT 'Дата, до якої документ має бути виконаним',
  `odr_execution_date` datetime DEFAULT NULL COMMENT 'Дата виконання документа',
  `odr_add_date` datetime NOT NULL,
  `odr_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Регістр вихідних документів із основними даними';

-- --------------------------------------------------------

--
-- Структура таблицы `df_terms_of_execution`
--

CREATE TABLE `df_terms_of_execution` (
  `toe_id` bigint UNSIGNED NOT NULL,
  `toe_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `toe_days` tinyint NOT NULL,
  `toe_add_date` datetime NOT NULL,
  `toe_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Терміни виконання для різних типів за контролем виконання';

-- --------------------------------------------------------

--
-- Структура таблицы `df_tg_messages`
--

CREATE TABLE `df_tg_messages` (
  `tgm_id` int NOT NULL,
  `tgm_chat_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'id TG пользователя',
  `tgm_msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgm_add_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Отправленные в Telegram сообщения';

-- --------------------------------------------------------

--
-- Структура таблицы `df_users`
--

CREATE TABLE `df_users` (
  `us_id` bigint UNSIGNED NOT NULL,
  `us_login` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `us_password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `us_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `us_id_tg` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Telegram id',
  `us_change_date` datetime DEFAULT NULL,
  `us_add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Структура таблицы `df_user_messages`
--

CREATE TABLE `df_user_messages` (
  `usm_id` bigint UNSIGNED NOT NULL,
  `usm_id_user` bigint UNSIGNED NOT NULL,
  `usm_id_sender` bigint UNSIGNED NOT NULL,
  `usm_header` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usm_msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usm_read` enum('y','n') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `usm_trash_bin` enum('y','n') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `usm_add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usm_change_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Приватні повідомлення користувачів';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `df_cron_tasks`
--
ALTER TABLE `df_cron_tasks`
  ADD PRIMARY KEY (`crt_id`),
  ADD UNIQUE KEY `uni_1` (`crt_task_name`),
  ADD UNIQUE KEY `uni_2` (`crt_schedule`);

--
-- Индексы таблицы `df_departments`
--
ALTER TABLE `df_departments`
  ADD PRIMARY KEY (`dp_id`),
  ADD KEY `dp_user` (`dp_id_user`);

--
-- Индексы таблицы `df_distribution_scopes`
--
ALTER TABLE `df_distribution_scopes`
  ADD PRIMARY KEY (`dsc_id`);

--
-- Индексы таблицы `df_document_carrier_types`
--
ALTER TABLE `df_document_carrier_types`
  ADD PRIMARY KEY (`cts_id`),
  ADD KEY `cts_user` (`cts_id_user`);

--
-- Индексы таблицы `df_document_control_types`
--
ALTER TABLE `df_document_control_types`
  ADD PRIMARY KEY (`dct_id`),
  ADD UNIQUE KEY `uni_1` (`dct_name`),
  ADD KEY `dct_user` (`dct_id_user`);

--
-- Индексы таблицы `df_document_descriptions`
--
ALTER TABLE `df_document_descriptions`
  ADD PRIMARY KEY (`dds_id`),
  ADD KEY `dds_user` (`dds_id_user`);

--
-- Индексы таблицы `df_document_resolutions`
--
ALTER TABLE `df_document_resolutions`
  ADD PRIMARY KEY (`drs_id`),
  ADD KEY `drs_user` (`drs_id_user`);

--
-- Индексы таблицы `df_document_senders`
--
ALTER TABLE `df_document_senders`
  ADD PRIMARY KEY (`dss_id`),
  ADD UNIQUE KEY `uni_1` (`dss_name`),
  ADD KEY `dss_user` (`dss_id_user`);

--
-- Индексы таблицы `df_document_statuses`
--
ALTER TABLE `df_document_statuses`
  ADD PRIMARY KEY (`dst_id`),
  ADD UNIQUE KEY `uni_1` (`dst_name`),
  ADD KEY `dst_user` (`dst_id_user`);

--
-- Индексы таблицы `df_document_titles`
--
ALTER TABLE `df_document_titles`
  ADD PRIMARY KEY (`dts_id`),
  ADD KEY `dts_user` (`dts_id_user`);

--
-- Индексы таблицы `df_document_types`
--
ALTER TABLE `df_document_types`
  ADD PRIMARY KEY (`dt_id`),
  ADD KEY `dt_user` (`dt_id_user`);

--
-- Индексы таблицы `df_incoming_documents_registry`
--
ALTER TABLE `df_incoming_documents_registry`
  ADD PRIMARY KEY (`idr_id`),
  ADD UNIQUE KEY `uni_1` (`idr_number`),
  ADD KEY `idr_document_format` (`idr_id_carrier_type`),
  ADD KEY `idr_assigned_departament` (`idr_id_assigned_departament`),
  ADD KEY `idr_description` (`idr_id_description`),
  ADD KEY `idr_document_type` (`idr_id_document_type`),
  ADD KEY `idr_outgoing_number` (`idr_id_outgoing_number`),
  ADD KEY `idr_resolution` (`idr_id_resolution`),
  ADD KEY `idr_responsible_user` (`idr_id_responsible_user`),
  ADD KEY `idr_sender` (`idr_id_sender`),
  ADD KEY `idr_status` (`idr_id_status`),
  ADD KEY `idr_title` (`idr_id_title`),
  ADD KEY `idr_user` (`idr_id_user`),
  ADD KEY `idr_document_location` (`idr_id_document_location`),
  ADD KEY `idr_assigned_user` (`idr_id_assigned_user`),
  ADD KEY `idr_execution_control` (`idr_id_execution_control`),
  ADD KEY `idr_term_of_execution` (`idr_id_term_of_execution`),
  ADD KEY `idr_recipient` (`idr_id_recipient`);

--
-- Индексы таблицы `df_internal_documents_registry`
--
ALTER TABLE `df_internal_documents_registry`
  ADD PRIMARY KEY (`inr_id`),
  ADD UNIQUE KEY `uni_1` (`inr_number`),
  ADD KEY `inr_user` (`inr_id_user`),
  ADD KEY `inr_carrier_type` (`inr_id_carrier_type`),
  ADD KEY `inr_document_location` (`inr_id_document_location`),
  ADD KEY `inr_document_type` (`inr_id_document_type`),
  ADD KEY `inr_title` (`inr_id_title`),
  ADD KEY `inr_initiator` (`inr_id_initiator`),
  ADD KEY `inr_recipient` (`inr_id_recipient`),
  ADD KEY `inr_description` (`inr_id_description`),
  ADD KEY `inr_status` (`inr_id_status`),
  ADD KEY `inr_responsible_user` (`inr_id_responsible_user`),
  ADD KEY `inr_assigned_departament` (`inr_id_assigned_departament`),
  ADD KEY `inr_assigned_user` (`inr_id_assigned_user`),
  ADD KEY `inr_execution_control` (`inr_id_execution_control`),
  ADD KEY `inr_term_of_execution` (`inr_id_term_of_execution`);

--
-- Индексы таблицы `df_outgoing_documents_registry`
--
ALTER TABLE `df_outgoing_documents_registry`
  ADD PRIMARY KEY (`odr_id`),
  ADD UNIQUE KEY `uni_1` (`odr_number`),
  ADD KEY `odr_user` (`odr_id_user`),
  ADD KEY `odr_document_type` (`odr_id_document_type`),
  ADD KEY `odr_carrier_type` (`odr_id_carrier_type`),
  ADD KEY `odr_document_location` (`odr_id_document_location`),
  ADD KEY `odr_incoming_number` (`odr_id_incoming_number`),
  ADD KEY `odr_title` (`odr_id_title`),
  ADD KEY `odr_sender` (`odr_id_sender`),
  ADD KEY `odr_recipient` (`odr_id_recipient`),
  ADD KEY `odr_description` (`odr_id_description`),
  ADD KEY `odr_status` (`odr_id_status`),
  ADD KEY `odr_assigned_user` (`odr_id_assigned_user`),
  ADD KEY `odr_execution_control` (`odr_id_execution_control`);

--
-- Индексы таблицы `df_terms_of_execution`
--
ALTER TABLE `df_terms_of_execution`
  ADD PRIMARY KEY (`toe_id`),
  ADD UNIQUE KEY `uni_1` (`toe_name`);

--
-- Индексы таблицы `df_tg_messages`
--
ALTER TABLE `df_tg_messages`
  ADD PRIMARY KEY (`tgm_id`);

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
-- Индексы таблицы `df_user_messages`
--
ALTER TABLE `df_user_messages`
  ADD PRIMARY KEY (`usm_id`),
  ADD KEY `usm_id_user` (`usm_id_user`),
  ADD KEY `usm_id_sender` (`usm_id_sender`);

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
  ADD PRIMARY KEY (`vr_id`),
  ADD KEY `vr_user` (`vr_id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `df_cron_tasks`
--
ALTER TABLE `df_cron_tasks`
  MODIFY `crt_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `df_departments`
--
ALTER TABLE `df_departments`
  MODIFY `dp_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `df_distribution_scopes`
--
ALTER TABLE `df_distribution_scopes`
  MODIFY `dsc_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_carrier_types`
--
ALTER TABLE `df_document_carrier_types`
  MODIFY `cts_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `df_document_control_types`
--
ALTER TABLE `df_document_control_types`
  MODIFY `dct_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `df_document_descriptions`
--
ALTER TABLE `df_document_descriptions`
  MODIFY `dds_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `df_document_resolutions`
--
ALTER TABLE `df_document_resolutions`
  MODIFY `drs_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `df_document_senders`
--
ALTER TABLE `df_document_senders`
  MODIFY `dss_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `df_document_statuses`
--
ALTER TABLE `df_document_statuses`
  MODIFY `dst_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `df_document_titles`
--
ALTER TABLE `df_document_titles`
  MODIFY `dts_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `df_document_types`
--
ALTER TABLE `df_document_types`
  MODIFY `dt_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `df_incoming_documents_registry`
--
ALTER TABLE `df_incoming_documents_registry`
  MODIFY `idr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `df_internal_documents_registry`
--
ALTER TABLE `df_internal_documents_registry`
  MODIFY `inr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `df_outgoing_documents_registry`
--
ALTER TABLE `df_outgoing_documents_registry`
  MODIFY `odr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `df_terms_of_execution`
--
ALTER TABLE `df_terms_of_execution`
  MODIFY `toe_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `df_tg_messages`
--
ALTER TABLE `df_tg_messages`
  MODIFY `tgm_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблицы `df_users`
--
ALTER TABLE `df_users`
  MODIFY `us_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT для таблицы `df_users_rel_statuses`
--
ALTER TABLE `df_users_rel_statuses`
  MODIFY `usr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT для таблицы `df_user_document_access`
--
ALTER TABLE `df_user_document_access`
  MODIFY `uda_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_user_messages`
--
ALTER TABLE `df_user_messages`
  MODIFY `usm_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `vr_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1670;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `df_departments`
--
ALTER TABLE `df_departments`
  ADD CONSTRAINT `dp_user` FOREIGN KEY (`dp_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_document_carrier_types`
--
ALTER TABLE `df_document_carrier_types`
  ADD CONSTRAINT `cts_user` FOREIGN KEY (`cts_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_document_control_types`
--
ALTER TABLE `df_document_control_types`
  ADD CONSTRAINT `dct_user` FOREIGN KEY (`dct_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_document_descriptions`
--
ALTER TABLE `df_document_descriptions`
  ADD CONSTRAINT `dds_user` FOREIGN KEY (`dds_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_document_resolutions`
--
ALTER TABLE `df_document_resolutions`
  ADD CONSTRAINT `drs_user` FOREIGN KEY (`drs_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_document_senders`
--
ALTER TABLE `df_document_senders`
  ADD CONSTRAINT `dss_user` FOREIGN KEY (`dss_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_document_statuses`
--
ALTER TABLE `df_document_statuses`
  ADD CONSTRAINT `dst_user` FOREIGN KEY (`dst_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_document_titles`
--
ALTER TABLE `df_document_titles`
  ADD CONSTRAINT `dts_user` FOREIGN KEY (`dts_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_document_types`
--
ALTER TABLE `df_document_types`
  ADD CONSTRAINT `dt_user` FOREIGN KEY (`dt_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_incoming_documents_registry`
--
ALTER TABLE `df_incoming_documents_registry`
  ADD CONSTRAINT `idr_assigned_departament` FOREIGN KEY (`idr_id_assigned_departament`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_assigned_user` FOREIGN KEY (`idr_id_assigned_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_description` FOREIGN KEY (`idr_id_description`) REFERENCES `df_document_descriptions` (`dds_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_document_format` FOREIGN KEY (`idr_id_carrier_type`) REFERENCES `df_document_carrier_types` (`cts_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_document_location` FOREIGN KEY (`idr_id_document_location`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_document_type` FOREIGN KEY (`idr_id_document_type`) REFERENCES `df_document_types` (`dt_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_execution_control` FOREIGN KEY (`idr_id_execution_control`) REFERENCES `df_document_control_types` (`dct_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_outgoing_number` FOREIGN KEY (`idr_id_outgoing_number`) REFERENCES `df_outgoing_documents_registry` (`odr_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_recipient` FOREIGN KEY (`idr_id_recipient`) REFERENCES `df_users` (`us_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `idr_resolution` FOREIGN KEY (`idr_id_resolution`) REFERENCES `df_document_resolutions` (`drs_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_responsible_user` FOREIGN KEY (`idr_id_responsible_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_sender` FOREIGN KEY (`idr_id_sender`) REFERENCES `df_document_senders` (`dss_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_status` FOREIGN KEY (`idr_id_status`) REFERENCES `df_document_statuses` (`dst_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_term_of_execution` FOREIGN KEY (`idr_id_term_of_execution`) REFERENCES `df_terms_of_execution` (`toe_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_title` FOREIGN KEY (`idr_id_title`) REFERENCES `df_document_titles` (`dts_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idr_user` FOREIGN KEY (`idr_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_internal_documents_registry`
--
ALTER TABLE `df_internal_documents_registry`
  ADD CONSTRAINT `inr_assigned_departament` FOREIGN KEY (`inr_id_assigned_departament`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_assigned_user` FOREIGN KEY (`inr_id_assigned_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_carrier_type` FOREIGN KEY (`inr_id_carrier_type`) REFERENCES `df_document_carrier_types` (`cts_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_description` FOREIGN KEY (`inr_id_description`) REFERENCES `df_document_descriptions` (`dds_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_document_location` FOREIGN KEY (`inr_id_document_location`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_document_type` FOREIGN KEY (`inr_id_document_type`) REFERENCES `df_document_types` (`dt_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_execution_control` FOREIGN KEY (`inr_id_execution_control`) REFERENCES `df_document_control_types` (`dct_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_initiator` FOREIGN KEY (`inr_id_initiator`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_recipient` FOREIGN KEY (`inr_id_recipient`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_responsible_user` FOREIGN KEY (`inr_id_responsible_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_status` FOREIGN KEY (`inr_id_status`) REFERENCES `df_user_statuses` (`uss_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_term_of_execution` FOREIGN KEY (`inr_id_term_of_execution`) REFERENCES `df_terms_of_execution` (`toe_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_title` FOREIGN KEY (`inr_id_title`) REFERENCES `df_document_titles` (`dts_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inr_user` FOREIGN KEY (`inr_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_outgoing_documents_registry`
--
ALTER TABLE `df_outgoing_documents_registry`
  ADD CONSTRAINT `odr_assigned_user` FOREIGN KEY (`odr_id_assigned_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_carrier_type` FOREIGN KEY (`odr_id_carrier_type`) REFERENCES `df_document_carrier_types` (`cts_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_description` FOREIGN KEY (`odr_id_description`) REFERENCES `df_document_descriptions` (`dds_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_document_location` FOREIGN KEY (`odr_id_document_location`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_document_type` FOREIGN KEY (`odr_id_document_type`) REFERENCES `df_document_types` (`dt_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_execution_control` FOREIGN KEY (`odr_id_execution_control`) REFERENCES `df_document_control_types` (`dct_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_incoming_number` FOREIGN KEY (`odr_id_incoming_number`) REFERENCES `df_incoming_documents_registry` (`idr_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_recipient` FOREIGN KEY (`odr_id_recipient`) REFERENCES `df_document_senders` (`dss_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_sender` FOREIGN KEY (`odr_id_sender`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_status` FOREIGN KEY (`odr_id_status`) REFERENCES `df_document_statuses` (`dst_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_title` FOREIGN KEY (`odr_id_title`) REFERENCES `df_document_titles` (`dts_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `odr_user` FOREIGN KEY (`odr_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_users_rel_statuses`
--
ALTER TABLE `df_users_rel_statuses`
  ADD CONSTRAINT `usr_status` FOREIGN KEY (`usr_id_status`) REFERENCES `df_user_statuses` (`uss_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `usr_user` FOREIGN KEY (`usr_id_user`) REFERENCES `df_users` (`us_id`);

--
-- Ограничения внешнего ключа таблицы `df_user_messages`
--
ALTER TABLE `df_user_messages`
  ADD CONSTRAINT `usm_sender` FOREIGN KEY (`usm_id_sender`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `usm_user` FOREIGN KEY (`usm_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_user_rel_departament`
--
ALTER TABLE `df_user_rel_departament`
  ADD CONSTRAINT `urd_departament` FOREIGN KEY (`urd_id_departament`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `urd_user` FOREIGN KEY (`urd_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_visitor_routes`
--
ALTER TABLE `df_visitor_routes`
  ADD CONSTRAINT `vr_user` FOREIGN KEY (`vr_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
