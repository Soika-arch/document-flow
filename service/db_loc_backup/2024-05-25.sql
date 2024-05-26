-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 25 2024 г., 12:57
-- Версия сервера: 8.0.36-0ubuntu0.22.04.1
-- Версия PHP: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- База данных: `petamicr`
--

-- --------------------------------------------------------

--
-- Структура таблицы `df_departments`
--

DROP TABLE IF EXISTS `df_departments`;
CREATE TABLE `df_departments` (
  `dp_id` bigint UNSIGNED NOT NULL,
  `dp_id_user` bigint UNSIGNED NOT NULL,
  `dp_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Назва відділу',
  `dp_add_date` datetime NOT NULL,
  `dp_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Відділи організації';

--
-- Дамп данных таблицы `df_departments`
--

INSERT INTO `df_departments` (`dp_id`, `dp_id_user`, `dp_name`, `dp_add_date`, `dp_change_date`) VALUES
(1, 1, 'Відділ управління персоналом', '2024-05-16 11:48:18', '2024-05-16 11:48:18'),
(2, 1, 'Фінансовий відділ', '2024-05-16 11:50:30', '2024-05-16 11:50:30'),
(3, 1, 'Відділ інформаційних технологій', '2024-05-16 11:50:30', '2024-05-16 11:50:30');

-- --------------------------------------------------------

--
-- Структура таблицы `df_distribution_scopes`
--

DROP TABLE IF EXISTS `df_distribution_scopes`;
CREATE TABLE `df_distribution_scopes` (
  `dsc_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_carrier_types`
--

DROP TABLE IF EXISTS `df_document_carrier_types`;
CREATE TABLE `df_document_carrier_types` (
  `cts_id` bigint UNSIGNED NOT NULL,
  `cts_id_user` bigint UNSIGNED NOT NULL,
  `cts_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cts_add_date` datetime NOT NULL,
  `cts_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Можливі типи носіів документів';

--
-- Дамп данных таблицы `df_document_carrier_types`
--

INSERT INTO `df_document_carrier_types` (`cts_id`, `cts_id_user`, `cts_name`, `cts_add_date`, `cts_change_date`) VALUES
(1, 1, 'Електронний носій', '2024-05-16 10:39:58', '2024-05-16 10:39:58'),
(2, 1, 'Паперовий носій', '2024-05-16 10:39:58', '2024-05-16 10:39:58'),
(3, 1, 'Мікрофільм', '2024-05-16 10:39:58', '2024-05-16 10:39:58');

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_control_types`
--

DROP TABLE IF EXISTS `df_document_control_types`;
CREATE TABLE `df_document_control_types` (
  `dct_id` bigint UNSIGNED NOT NULL,
  `dct_id_user` bigint UNSIGNED NOT NULL,
  `dct_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dct_add_date` datetime NOT NULL,
  `dct_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Видів контролю за виконанням документів';

--
-- Дамп данных таблицы `df_document_control_types`
--

INSERT INTO `df_document_control_types` (`dct_id`, `dct_id_user`, `dct_name`, `dct_add_date`, `dct_change_date`) VALUES
(1, 1, 'Разово', '2024-05-16 13:29:21', '2024-05-16 13:29:21'),
(2, 1, 'Щодня', '2024-05-16 13:29:21', '2024-05-16 13:29:21'),
(3, 1, 'Щотижня', '2024-05-16 13:29:57', '2024-05-16 13:29:57'),
(4, 1, 'Щомісяця', '2024-05-16 13:29:57', '2024-05-16 13:29:57'),
(7, 1, 'Щорічно', '2024-05-16 13:29:57', '2024-05-16 13:29:57');

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_descriptions`
--

DROP TABLE IF EXISTS `df_document_descriptions`;
CREATE TABLE `df_document_descriptions` (
  `dds_id` bigint UNSIGNED NOT NULL,
  `dds_id_user` bigint NOT NULL,
  `dds_description` text COLLATE utf8mb4_unicode_ci,
  `dds_add_date` datetime NOT NULL,
  `dds_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Опис або короткий зміст документів';

--
-- Дамп данных таблицы `df_document_descriptions`
--

INSERT INTO `df_document_descriptions` (`dds_id`, `dds_id_user`, `dds_description`, `dds_add_date`, `dds_change_date`) VALUES
(1, 1, 'Тестовий короткий зміст документа', '2024-05-17 14:19:29', '2024-05-17 14:19:29');

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_locations`
--

DROP TABLE IF EXISTS `df_document_locations`;
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

DROP TABLE IF EXISTS `df_document_resolutions`;
CREATE TABLE `df_document_resolutions` (
  `drs_id` bigint UNSIGNED NOT NULL,
  `drs_id_user` bigint UNSIGNED NOT NULL,
  `drs_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `drs_add_date` datetime NOT NULL,
  `drs_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Резолюції документів';

--
-- Дамп данных таблицы `df_document_resolutions`
--

INSERT INTO `df_document_resolutions` (`drs_id`, `drs_id_user`, `drs_content`, `drs_add_date`, `drs_change_date`) VALUES
(1, 1, 'До виконання', '2024-05-16 12:25:57', '2024-05-16 12:25:57'),
(2, 1, 'На контроль', '2024-05-16 12:25:57', '2024-05-16 12:25:57'),
(3, 1, 'До відома', '2024-05-16 12:27:17', '2024-05-16 12:27:17'),
(4, 1, 'На узгодження', '2024-05-16 12:27:17', '2024-05-16 12:27:17');

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_senders`
--

DROP TABLE IF EXISTS `df_document_senders`;
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

--
-- Дамп данных таблицы `df_document_senders`
--

INSERT INTO `df_document_senders` (`dss_id`, `dss_id_user`, `dss_name`, `dss_email`, `dss_phone`, `dss_address`, `dss_legal_address`, `dss_add_date`, `dss_change_date`) VALUES
(1, 1, 'Test', 'test@email.com', '0999999999', 'sfasf sfasf', 'sfsdf scdsfsdg', '2024-05-17 13:06:39', '2024-05-17 13:06:39');

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_statuses`
--

DROP TABLE IF EXISTS `df_document_statuses`;
CREATE TABLE `df_document_statuses` (
  `dst_id` bigint UNSIGNED NOT NULL,
  `dst_id_user` bigint UNSIGNED NOT NULL COMMENT 'Користовач, який створив статус',
  `dst_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dst_add_date` datetime NOT NULL,
  `dst_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Статуси документів (новий, в обробці ...)';

--
-- Дамп данных таблицы `df_document_statuses`
--

INSERT INTO `df_document_statuses` (`dst_id`, `dst_id_user`, `dst_name`, `dst_add_date`, `dst_change_date`) VALUES
(1, 1, 'Новий', '2024-05-16 11:19:58', '2024-05-16 11:19:58'),
(2, 1, 'В обробці', '2024-05-16 11:20:09', '2024-05-16 11:20:09');

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_titles`
--

DROP TABLE IF EXISTS `df_document_titles`;
CREATE TABLE `df_document_titles` (
  `dts_id` bigint UNSIGNED NOT NULL,
  `dts_id_user` bigint UNSIGNED NOT NULL,
  `dts_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dts_add_date` datetime NOT NULL,
  `dts_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Назви або заголовоки документів';

--
-- Дамп данных таблицы `df_document_titles`
--

INSERT INTO `df_document_titles` (`dts_id`, `dts_id_user`, `dts_title`, `dts_add_date`, `dts_change_date`) VALUES
(1, 1, 'Тестова назва документа', '2024-05-17 14:15:53', '2024-05-17 14:15:53'),
(2, 1, 'Тестова назва документа 2', '2024-05-17 14:15:53', '2024-05-17 14:15:53'),
(3, 1, 'Тестова назва документа 3', '2024-05-17 14:15:53', '2024-05-17 14:15:53');

-- --------------------------------------------------------

--
-- Структура таблицы `df_document_types`
--

DROP TABLE IF EXISTS `df_document_types`;
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
(4, 1, 'Протокол', 'Протокол наради', '2024-05-04 14:31:32', '2024-05-04 14:31:32'),
(8, 1, 'Уведомительное сообщение', 'Це тип документа, який використовується для передачі інформації або сповіщення всередині організації чи підприємства. Воно може містити важливі оголошення, повідомлення про події, інформацію про зміни в процесах або правилах, запрошення на заходи тощо. д. Повідомлення зазвичай мають короткий формат і спрямовані на оперативне інформування співробітників або зацікавлених сторін про важливі події або обставини.', '2024-05-15 20:35:02', '2024-05-15 20:35:02'),
(9, 1, 'Наказ про призначення посаду', 'Цей наказ видається керівництвом підприємства для офіційного призначення співробітника певну посаду всередині організації. У наказі вказується ПІБ співробітника, його нова посада, дата початку роботи на новій посаді, а також інші відповідні деталі, такі як відділ або підрозділ, до якого він належить. Такий наказ є офіційним повідомленням про зміну посади та статусу співробітника в організації', '2024-05-15 20:37:42', '2024-05-15 20:37:42'),
(10, 1, 'Наказ про проведення інструктажу з охорони праці', 'Цей наказ видається керівництвом підприємства щодо обов&#039;язкового інструктажу з питань охорони праці серед співробітників. У наказі зазначається дата та час проведення інструктажу, а також відповідні вимоги та інструкції, які мають бути подані під час інструктажу. Такий наказ спрямований на забезпечення безпеки та здоров&#039;я працівників на робочому місці шляхом надання їм необхідної інформації та інструктажу щодо правил та процедур з охорони праці.', '2024-05-15 20:38:54', '2024-05-15 20:38:54'),
(11, 1, 'Наказ про преміювання працівника', 'Цей наказ видається керівництвом підприємства для офіційного повідомлення співробітника про намір преміювати його за досягнення, визначні результати роботи, виконання поставленої мети або інші заслуги. У наказі вказується сума премії, підстава для її призначення, а також дата та порядок виплати. Такий наказ служить для заохочення співробітників за їхню хорошу роботу та мотивації до досягнення кращих результатів', '2024-05-15 20:41:13', '2024-05-15 20:41:13'),
(12, 1, 'Вхідний лист від контрагента', 'Це вхідний документ, отриманий вашим підприємством від зовнішнього контрагента чи партнера. Зазвичай такі листи містять інформацію про пропозиції, запити, замовлення, рекламні матеріали, юридичні документи або будь-яку іншу важливу інформацію щодо взаємодії з контрагентом. Вхідні листи можуть бути направлені на обговорення подальших дій, відповіді на запитання, запити на надання додаткової інформації чи інші заходи', '2024-05-15 20:43:01', '2024-05-15 20:43:01'),
(13, 1, 'Вхідний акт приймання-передачі товарів', 'Це вхідний документ, отриманий вашим підприємством від постачальника товарів чи послуг. У такому акті зазвичай фіксуються деталі про поставлені товари чи послуги, їх кількість, якість, вартість та інші суттєві характеристики. Цей документ є підставою для приймання товарів чи послуг і може використовуватися для перевірки відповідності поставлених матеріалів чи послуг умовам контракту чи замовлення', '2024-05-15 20:44:17', '2024-05-15 20:44:17'),
(14, 1, 'Вхідний звіт про виконані роботи від підрозділу', 'Це документ, отриманий вашим підприємством від одного з підрозділів організації. Звіт про виконані роботи зазвичай містить інформацію про виконану роботу, досягнуті результати, витрачені ресурси (час, матеріали, працю) та інші істотні деталі виконаних завдань. Такі звіти можуть бути використані для оцінки ефективності роботи підрозділів, складання загальних звітів про діяльність підприємства, а також для прийняття управлінських рішень', '2024-05-15 20:45:18', '2024-05-15 20:45:18');

-- --------------------------------------------------------

--
-- Структура таблицы `df_incoming_documents_registry`
--

DROP TABLE IF EXISTS `df_incoming_documents_registry`;
CREATE TABLE `df_incoming_documents_registry` (
  `idr_id` bigint UNSIGNED NOT NULL,
  `idr_id_user` bigint UNSIGNED NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `idr_id_document_type` bigint UNSIGNED NOT NULL COMMENT 'Тип документа',
  `idr_id_carrier_type` bigint UNSIGNED NOT NULL COMMENT 'Тип носія документа',
  `idr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Відділ фізичного місцезнаходження оригінала',
  `idr_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер вхідного документа',
  `idr_id_outgoing_number` bigint UNSIGNED DEFAULT NULL COMMENT 'Номер вихідного',
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

--
-- Дамп данных таблицы `df_incoming_documents_registry`
--

INSERT INTO `df_incoming_documents_registry` (`idr_id`, `idr_id_user`, `idr_id_document_type`, `idr_id_carrier_type`, `idr_id_document_location`, `idr_number`, `idr_id_outgoing_number`, `idr_id_title`, `idr_document_date`, `idr_id_recipient`, `idr_id_sender`, `idr_id_description`, `idr_file_extension`, `idr_id_status`, `idr_id_responsible_user`, `idr_id_assigned_user`, `idr_id_assigned_departament`, `idr_id_resolution`, `idr_resolution_date`, `idr_date_of_receipt_by_executor`, `idr_id_execution_control`, `idr_id_term_of_execution`, `idr_control_date`, `idr_execution_date`, `idr_add_date`, `idr_change_date`) VALUES
(1, 1, 1, 1, 1, 'inc_7s1h56', NULL, 1, '2024-05-18', 1, 1, 1, 'jpg', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-18 18:56:45', '2024-05-18 18:56:45'),
(2, 1, 12, 1, 3, 'inc_66r74h', NULL, 1, '2024-05-19', 47, 1, 1, 'pdf', 1, 47, 1, 3, 1, NULL, NULL, 2, NULL, '2024-05-31 00:00:00', NULL, '2024-05-19 12:22:30', '2024-05-19 12:22:30'),
(3, 1, 3, 1, 2, 'inc_q39v45', NULL, 2, '2024-05-19', 47, 1, 1, 'pdf', 1, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, '2024-05-19 12:30:46', '2024-05-19 12:30:46'),
(4, 1, 8, 1, 1, 'inc_5537gy', NULL, 3, '2024-05-19', NULL, 1, 1, 'pdf', 1, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-19 12:31:37', '2024-05-19 12:31:37'),
(5, 1, 11, 1, 1, 'inc_73r04o', NULL, 1, '2024-05-19', 47, 1, 1, 'jpg', 1, 47, 1, 2, 2, NULL, NULL, 1, NULL, NULL, NULL, '2024-05-19 12:32:53', '2024-05-19 12:32:53'),
(6, 1, 9, 1, 1, 'inc_93v1n0', NULL, 2, '2024-05-19', 47, 1, NULL, 'jpg', 2, 47, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2024-05-19 12:40:03', '2024-05-19 12:40:03'),
(7, 1, 1, 1, 2, 'inc_ox818f', NULL, 3, '2024-05-19', 50, 1, 1, 'pdf', 2, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-19 17:26:16', '2024-05-19 17:26:16'),
(8, 1, 1, 1, 2, 'inc_u8mlfy', NULL, 2, '2024-05-19', 51, 1, 1, 'pdf', 1, 50, NULL, NULL, NULL, NULL, NULL, 2, 2, NULL, NULL, '2024-05-19 17:31:22', '2024-05-19 17:31:22'),
(9, 1, 14, 1, 2, 'inc_z7ynk3', NULL, 1, '2024-05-22', 50, 1, 1, 'pdf', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2024-05-22 19:23:54', '2024-05-22 19:23:54'),
(10, 1, 1, 1, NULL, 'inc_5hgi1l', NULL, 2, NULL, 1, 1, 1, 'pdf', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-22 19:26:39', '2024-05-22 19:26:39'),
(11, 1, 1, 1, 1, 'inc_2u0k2z', NULL, 2, '2024-05-23', 1, 1, 1, 'jpg', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-23 05:06:58', '2024-05-23 05:06:58'),
(12, 1, 1, 1, 2, 'inc_gzxekf', NULL, 2, '2024-05-23', 1, 1, 1, 'png', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-23 15:42:18', '2024-05-23 15:42:18'),
(13, 1, 1, 1, 2, 'inc_u1ziqp', NULL, 2, '2024-05-23', 1, 1, 1, 'png', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-23 15:44:15', '2024-05-23 15:44:15'),
(14, 1, 1, 1, 2, 'inc_wqky1p', NULL, 2, '2024-05-23', 1, 1, 1, 'png', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-23 16:11:37', '2024-05-23 16:11:37'),
(15, 1, 9, 1, 1, 'inc_g8jb3p', NULL, 1, '2022-05-25', 1, 1, 1, 'docx', 2, 50, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-25 00:23:24', '2024-05-25 00:23:24'),
(16, 1, 12, 1, 3, 'inc_pp0s0l', NULL, 2, '2020-03-11', 51, 1, 1, 'png', 2, 51, 50, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-25 12:26:14', '2024-05-25 12:26:14');

-- --------------------------------------------------------

--
-- Структура таблицы `df_internal_documents_registry`
--

DROP TABLE IF EXISTS `df_internal_documents_registry`;
CREATE TABLE `df_internal_documents_registry` (
  `inr_id` bigint UNSIGNED NOT NULL,
  `inr_id_user` int NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `inr_id_carrier_type` bigint UNSIGNED NOT NULL COMMENT 'Тип носія документа',
  `inr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Фізичне місцезнаходження оригінала',
  `inr_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер документа',
  `inr_additional_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Додатковий номер',
  `inr_id_document_type` bigint NOT NULL COMMENT 'Тип документа',
  `inr_id_title` bigint UNSIGNED NOT NULL COMMENT 'Назва чи заголовок документа',
  `inr_document_date` datetime DEFAULT NULL COMMENT 'Дата в документі',
  `inr_id_initiator` bigint UNSIGNED NOT NULL COMMENT 'Ініціатор (користувач)',
  `inr_id_recipient` bigint UNSIGNED DEFAULT NULL COMMENT 'Отримувач (користувач)',
  `inr_id_description` bigint UNSIGNED DEFAULT NULL COMMENT 'Опис або короткий зміст документа',
  `inr_file_extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Розширення файлу завантаженого документа',
  `inr_id_status` bigint UNSIGNED DEFAULT NULL COMMENT 'Статус документа (наприклад, "новий", "в обробці", "завершено")',
  `inr_id_responsible_user` bigint UNSIGNED DEFAULT NULL COMMENT 'id відповідального за виконання',
  `inr_id_assigned_departament` bigint UNSIGNED DEFAULT NULL COMMENT 'id відділа, якому призначено на виконання',
  `inr_id_assigned_user` bigint UNSIGNED DEFAULT NULL COMMENT 'Призначений користувач обробки документа.',
  `inr_date_of_receipt_by_executor` bigint UNSIGNED DEFAULT NULL COMMENT 'Дата надходження виконавцю',
  `inr_id_execution_control` bigint UNSIGNED DEFAULT NULL COMMENT 'Контроль виконання: one-time, monthly, quarterly, annually',
  `inr_id_term_of_execution` bigint UNSIGNED DEFAULT NULL COMMENT 'Термін виконання в днях',
  `inr_control_date` datetime DEFAULT NULL COMMENT 'Дата, до якої документ має бути виконаним',
  `inr_execution_date` datetime DEFAULT NULL COMMENT 'Дата виконання документа',
  `inr_distribution_scope` bigint UNSIGNED DEFAULT NULL COMMENT 'Поширюється на',
  `inr_add_date` datetime NOT NULL,
  `inr_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Регістр вихідних документів із основними даними';

--
-- Дамп данных таблицы `df_internal_documents_registry`
--

INSERT INTO `df_internal_documents_registry` (`inr_id`, `inr_id_user`, `inr_id_carrier_type`, `inr_id_document_location`, `inr_number`, `inr_additional_number`, `inr_id_document_type`, `inr_id_title`, `inr_document_date`, `inr_id_initiator`, `inr_id_recipient`, `inr_id_description`, `inr_file_extension`, `inr_id_status`, `inr_id_responsible_user`, `inr_id_assigned_departament`, `inr_id_assigned_user`, `inr_date_of_receipt_by_executor`, `inr_id_execution_control`, `inr_id_term_of_execution`, `inr_control_date`, `inr_execution_date`, `inr_distribution_scope`, `inr_add_date`, `inr_change_date`) VALUES
(1, 1, 1, 2, 'int_qswhhn', NULL, 14, 2, '2024-05-23 00:00:00', 1, 50, 1, 'jpg', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-23 05:13:56', '2024-05-23 05:13:56'),
(2, 1, 1, 1, 'int_e6jbu3', '94ht6r', 9, 2, '2024-05-23 00:00:00', 47, 47, 1, 'jpg', 2, 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-23 18:45:19', '2024-05-23 18:45:19'),
(3, 1, 1, 1, 'int_dlaniq', '94ht6r', 9, 2, '2024-05-23 00:00:00', 47, 47, 1, 'jpg', 2, 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-23 18:46:35', '2024-05-23 18:46:35');

-- --------------------------------------------------------

--
-- Структура таблицы `df_outgoing_documents_registry`
--

DROP TABLE IF EXISTS `df_outgoing_documents_registry`;
CREATE TABLE `df_outgoing_documents_registry` (
  `odr_id` bigint UNSIGNED NOT NULL,
  `odr_id_user` bigint UNSIGNED NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `odr_id_document_type` bigint UNSIGNED NOT NULL COMMENT 'Тип документа',
  `odr_id_carrier_type` bigint UNSIGNED NOT NULL COMMENT 'Тип носія документа',
  `odr_id_document_location` bigint UNSIGNED DEFAULT NULL COMMENT 'Фізичне місцезнаходження оригінала',
  `odr_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер вихідного документа',
  `odr_id_incoming_number` bigint UNSIGNED DEFAULT NULL COMMENT 'Номер відповідного вхідного',
  `odr_registration_form_number` bigint UNSIGNED DEFAULT NULL COMMENT 'Реєстраційний номер бланка',
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

--
-- Дамп данных таблицы `df_outgoing_documents_registry`
--

INSERT INTO `df_outgoing_documents_registry` (`odr_id`, `odr_id_user`, `odr_id_document_type`, `odr_id_carrier_type`, `odr_id_document_location`, `odr_number`, `odr_id_incoming_number`, `odr_registration_form_number`, `odr_id_title`, `odr_document_date`, `odr_id_sender`, `odr_id_recipient`, `odr_id_description`, `odr_file_extension`, `odr_id_status`, `odr_id_assigned_user`, `odr_id_execution_control`, `odr_control_date`, `odr_execution_date`, `odr_add_date`, `odr_change_date`) VALUES
(1, 1, 1, 1, NULL, 'out_wpe7vn', NULL, 1, 2, '2024-05-22', 1, 1, 1, 'pdf', 1, NULL, NULL, NULL, NULL, '2024-05-22 19:33:24', '2024-05-22 19:33:24'),
(2, 1, 3, 1, NULL, 'out_022k5q', 1, 2, 2, '2024-05-23', 47, 1, 1, 'jpg', 1, NULL, 2, NULL, NULL, '2024-05-23 02:44:09', '2024-05-23 02:44:09'),
(3, 1, 8, 1, NULL, 'out_tw5uw7', NULL, 1, 2, '2024-05-23', 51, 1, 1, 'png', 1, NULL, NULL, NULL, NULL, '2024-05-23 03:15:53', '2024-05-23 03:15:53'),
(4, 1, 12, 1, NULL, 'out_0m0fgb', NULL, 2, 3, '2024-05-23', 50, 1, 1, 'png', 1, NULL, NULL, NULL, NULL, '2024-05-23 03:16:45', '2024-05-23 03:16:45'),
(5, 1, 1, 1, NULL, 'out_58vw9y', NULL, 1, 3, '2024-05-23', 1, 1, 1, 'png', 1, NULL, 4, NULL, NULL, '2024-05-23 03:17:53', '2024-05-23 03:17:53'),
(6, 1, 4, 1, NULL, 'out_klso1e', NULL, 1, 1, '2024-05-22', 47, 1, 1, 'png', 2, NULL, NULL, NULL, NULL, '2024-05-23 03:18:46', '2024-05-23 03:18:46'),
(7, 1, 4, 2, 1, 'inc_e7ojlp', NULL, 1, 1, '2024-05-23', 50, 1, 1, 'pdf', 1, NULL, 3, NULL, NULL, '2024-05-23 18:43:34', '2024-05-23 18:43:34');

-- --------------------------------------------------------

--
-- Структура таблицы `df_registration_forms`
--

DROP TABLE IF EXISTS `df_registration_forms`;
CREATE TABLE `df_registration_forms` (
  `rf_id` bigint UNSIGNED NOT NULL,
  `rf_id_user` bigint UNSIGNED NOT NULL,
  `rf_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rf_add_date` datetime NOT NULL,
  `rf_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Бланки документів';

--
-- Дамп данных таблицы `df_registration_forms`
--

INSERT INTO `df_registration_forms` (`rf_id`, `rf_id_user`, `rf_name`, `rf_add_date`, `rf_change_date`) VALUES
(1, 1, 'Blank 1', '2024-05-22 15:57:02', '2024-05-22 15:57:02'),
(2, 1, 'Blank 2', '2024-05-22 15:57:02', '2024-05-22 15:57:02');

-- --------------------------------------------------------

--
-- Структура таблицы `df_terms_of_execution`
--

DROP TABLE IF EXISTS `df_terms_of_execution`;
CREATE TABLE `df_terms_of_execution` (
  `toe_id` bigint UNSIGNED NOT NULL,
  `toe_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `toe_days` tinyint NOT NULL,
  `toe_add_date` datetime NOT NULL,
  `toe_change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Терміни виконання для різних типів за контролем виконання';

--
-- Дамп данных таблицы `df_terms_of_execution`
--

INSERT INTO `df_terms_of_execution` (`toe_id`, `toe_name`, `toe_days`, `toe_add_date`, `toe_change_date`) VALUES
(1, 'Стандартний', 10, '2024-05-19 13:25:17', '2024-05-19 13:25:17'),
(2, 'Терміновий', 3, '2024-05-19 13:25:17', '2024-05-19 13:25:17');

-- --------------------------------------------------------

--
-- Структура таблицы `df_users`
--

DROP TABLE IF EXISTS `df_users`;
CREATE TABLE `df_users` (
  `us_id` bigint UNSIGNED NOT NULL,
  `us_login` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `us_password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `us_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `us_change_date` datetime DEFAULT NULL,
  `us_add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `df_users`
--

INSERT INTO `df_users` (`us_id`, `us_login`, `us_password_hash`, `us_email`, `us_change_date`, `us_add_date`) VALUES
(0, 'Guest', '', '', '2024-05-01 20:17:18', '2024-04-14 16:05:13'),
(1, 'Admin', '$2y$10$vEIigCI0EotxwtiXyhE8V.fTo6CgjQhhK78zPWlYwm8XV17WTdkYu', 'test@gmail.com', '2024-05-23 20:17:26', '2024-04-14 16:05:13'),
(47, 'Dvemerixs', '$2y$10$6BTC4Yv/oQU38ZXnP3h1UexK0QiDN10ERNds44dMRVhpvkLddDwlu', 'test2@gmail.com', '2024-05-24 21:51:24', '2024-05-13 16:13:37'),
(50, 'Dvemerix-user', '$2y$10$NujZEa58r1.eCEYNwbY4f.7eqhXR61pfLRkSIoclL8MRgAd5UjYki', 'test1@gmail.com', '2024-05-23 20:17:33', '2024-05-19 14:21:00'),
(51, 'Dvemerix-viewer', '$2y$10$lMtdtFye.IsvStLAJ8yhDOCin2uocWWRW0/vzjjJxyx6TqQ9eNPPy', 'test3@gmail.com', '2024-05-23 20:17:35', '2024-05-19 14:26:18');

-- --------------------------------------------------------

--
-- Структура таблицы `df_users_rel_statuses`
--

DROP TABLE IF EXISTS `df_users_rel_statuses`;
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
(2, 0, 5, '2024-04-24 19:32:45', '2024-04-24 19:32:45'),
(29, 50, 3, '2024-05-19 14:21:00', '2024-05-19 14:21:00'),
(30, 51, 4, '2024-05-19 14:26:18', '2024-05-19 14:26:18'),
(35, 47, 3, '2024-05-24 21:51:24', '2024-05-24 21:51:24');

-- --------------------------------------------------------

--
-- Структура таблицы `df_user_document_access`
--

DROP TABLE IF EXISTS `df_user_document_access`;
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

DROP TABLE IF EXISTS `df_user_rel_departament`;
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

DROP TABLE IF EXISTS `df_user_statuses`;
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

DROP TABLE IF EXISTS `df_visitor_routes`;
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
(1, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 12:57:40'),
(2, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 5, 0.00615, '2024-05-25 12:57:40'),
(3, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 9, 0.00675, '2024-05-25 12:57:40'),
(4, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 12:57:42'),
(5, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 9, 0.00775, '2024-05-25 12:57:42'),
(6, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01618, '2024-05-25 12:57:43'),
(7, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01508, '2024-05-25 12:57:44'),
(8, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 12:57:49'),
(9, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 16, 0.01254, '2024-05-25 12:57:49'),
(10, 1, '127.0.0.1', 'df?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 12:57:50'),
(11, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00995, '2024-05-25 12:57:50'),
(12, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.0169, '2024-05-25 12:59:09'),
(13, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01579, '2024-05-25 12:59:10'),
(14, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01189, '2024-05-25 12:59:12'),
(15, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 12:59:16'),
(16, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 16, 0.00822, '2024-05-25 12:59:16'),
(17, 1, '127.0.0.1', 'df?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 12:59:18'),
(18, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00895, '2024-05-25 12:59:18'),
(19, 1, '127.0.0.1', 'df/documents-incoming/list?pg=4', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 12:59:30'),
(20, 1, '127.0.0.1', 'df/documents-incoming/list?pg=4', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.01392, '2024-05-25 13:01:45'),
(21, 1, '127.0.0.1', 'df/search?uri=df_documents-incoming_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01433, '2024-05-25 13:01:52'),
(22, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:01:56'),
(23, 1, '127.0.0.1', 'df_documents-incoming_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 9, 0.00726, '2024-05-25 13:01:56'),
(24, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 16, 0.01377, '2024-05-25 13:02:15'),
(25, 1, '127.0.0.1', 'df?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:02:21'),
(26, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00981, '2024-05-25 13:02:21'),
(27, 1, '127.0.0.1', 'df/documents-incoming/list?pg=4', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.01595, '2024-05-25 13:02:24'),
(28, 1, '127.0.0.1', 'df/search?uri=df_documents-incoming_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01172, '2024-05-25 13:02:29'),
(29, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:03:51'),
(30, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:04:38'),
(31, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.0092, '2024-05-25 13:04:38'),
(32, 1, '127.0.0.1', 'df/documents-incoming/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:04:43'),
(33, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01128, '2024-05-25 13:04:43'),
(34, 1, '127.0.0.1', 'df/documents-incoming/list?pg=4', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.01529, '2024-05-25 13:04:47'),
(35, 1, '127.0.0.1', 'df/search?uri=df_documents-incoming_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01128, '2024-05-25 13:04:49'),
(36, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:04:55'),
(37, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 16, 0.00909, '2024-05-25 13:04:55'),
(38, 1, '127.0.0.1', 'df/documents-incoming/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:05:00'),
(39, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00829, '2024-05-25 13:05:00'),
(40, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01652, '2024-05-25 13:06:14'),
(41, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.00978, '2024-05-25 13:06:20'),
(42, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:07:55'),
(43, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:08:43'),
(44, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01228, '2024-05-25 13:08:54'),
(45, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01076, '2024-05-25 13:08:56'),
(46, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:11:04'),
(47, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.0108, '2024-05-25 13:11:37'),
(48, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:11:53'),
(49, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:12:12'),
(50, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:13:01'),
(51, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:13:24'),
(52, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00938, '2024-05-25 13:13:24'),
(53, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01851, '2024-05-25 13:15:29'),
(54, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:15:33'),
(55, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:16:00'),
(56, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.0088, '2024-05-25 13:16:00'),
(57, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01438, '2024-05-25 13:16:03'),
(58, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:16:08'),
(59, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00885, '2024-05-25 13:16:08'),
(60, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:16:19'),
(61, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:24:08'),
(62, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 16, 0.01459, '2024-05-25 13:24:21'),
(63, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:24:23'),
(64, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00867, '2024-05-25 13:24:23'),
(65, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01144, '2024-05-25 13:24:25'),
(66, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:24:35'),
(67, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.00909, '2024-05-25 13:24:35'),
(68, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:24:37'),
(69, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01114, '2024-05-25 13:24:37'),
(70, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.0093, '2024-05-25 13:25:16'),
(71, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:25:20'),
(72, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.00915, '2024-05-25 13:25:20'),
(73, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:25:23'),
(74, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01047, '2024-05-25 13:25:23'),
(75, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01744, '2024-05-25 13:25:24'),
(76, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:25:28'),
(77, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.00865, '2024-05-25 13:25:28'),
(78, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:25:29'),
(79, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01033, '2024-05-25 13:25:29'),
(80, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01057, '2024-05-25 13:25:42'),
(81, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:25:47'),
(82, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 16, 0.01069, '2024-05-25 13:25:47'),
(83, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:25:49'),
(84, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00924, '2024-05-25 13:25:49'),
(85, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01707, '2024-05-25 13:25:50'),
(86, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:25:53'),
(87, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 16, 0.00915, '2024-05-25 13:25:53'),
(88, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:26:24'),
(89, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01017, '2024-05-25 13:26:24'),
(90, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01178, '2024-05-25 13:26:25'),
(91, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:26:29'),
(92, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 16, 0.00761, '2024-05-25 13:26:29'),
(93, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:26:30'),
(94, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01053, '2024-05-25 13:26:30'),
(95, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01007, '2024-05-25 13:26:31'),
(96, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:26:34'),
(97, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.00722, '2024-05-25 13:26:34'),
(98, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:26:36'),
(99, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00981, '2024-05-25 13:26:36'),
(100, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01413, '2024-05-25 13:28:28'),
(101, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.00995, '2024-05-25 13:28:29'),
(102, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:28:32'),
(103, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:29:56'),
(104, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00855, '2024-05-25 13:29:56'),
(105, 1, '127.0.0.1', 'df?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:30:00'),
(106, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00884, '2024-05-25 13:30:00'),
(107, 1, '127.0.0.1', 'df?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:50:54'),
(108, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 5, 0.00487, '2024-05-25 13:50:54'),
(109, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 9, 0.00598, '2024-05-25 13:50:54'),
(110, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:50:56'),
(111, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 9, 0.00646, '2024-05-25 13:50:56'),
(112, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01328, '2024-05-25 13:50:57'),
(113, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.01451, '2024-05-25 13:50:59'),
(114, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01216, '2024-05-25 13:51:03'),
(115, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:51:10'),
(116, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.00749, '2024-05-25 13:51:10'),
(117, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:51:13'),
(118, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.00982, '2024-05-25 13:51:13'),
(119, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01356, '2024-05-25 13:51:59'),
(120, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:52:04'),
(121, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.00754, '2024-05-25 13:52:04'),
(122, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:52:05'),
(123, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.00772, '2024-05-25 13:52:05'),
(124, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01252, '2024-05-25 13:52:07'),
(125, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:52:13'),
(126, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 16, 0.01, '2024-05-25 13:52:13'),
(127, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:52:14'),
(128, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.01008, '2024-05-25 13:52:14'),
(129, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01325, '2024-05-25 13:52:17'),
(130, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:52:21'),
(131, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.01098, '2024-05-25 13:52:21'),
(132, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:52:22'),
(133, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.00808, '2024-05-25 13:52:22'),
(134, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01288, '2024-05-25 13:53:25'),
(135, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:53:28'),
(136, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.00913, '2024-05-25 13:53:28'),
(137, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:53:30'),
(138, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.01012, '2024-05-25 13:53:30'),
(139, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01508, '2024-05-25 13:53:42'),
(140, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:53:46'),
(141, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 16, 0.00782, '2024-05-25 13:53:46'),
(142, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:53:47'),
(143, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.0093, '2024-05-25 13:53:47'),
(144, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01269, '2024-05-25 13:53:48'),
(145, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:53:51'),
(146, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.00743, '2024-05-25 13:53:51'),
(147, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 13:53:52'),
(148, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.00994, '2024-05-25 13:53:52'),
(149, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.0178, '2024-05-25 13:57:52'),
(150, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01539, '2024-05-25 13:57:53'),
(151, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:00:44'),
(152, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:01:50'),
(153, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.00918, '2024-05-25 14:01:50'),
(154, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:02:00'),
(155, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.01017, '2024-05-25 14:02:00'),
(156, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.03341, '2024-05-25 14:02:08'),
(157, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:07:39'),
(158, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.00872, '2024-05-25 14:07:39'),
(159, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:07:43'),
(160, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.00842, '2024-05-25 14:07:43'),
(161, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01062, '2024-05-25 14:07:49'),
(162, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:07:52'),
(163, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.00754, '2024-05-25 14:07:52'),
(164, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:07:54'),
(165, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.00851, '2024-05-25 14:07:54'),
(166, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01418, '2024-05-25 14:08:41'),
(167, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01322, '2024-05-25 14:08:42'),
(168, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01213, '2024-05-25 14:08:48'),
(169, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01348, '2024-05-25 14:08:50'),
(170, 1, '127.0.0.1', 'df/search?uri=df_documents-incoming_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01402, '2024-05-25 14:08:51'),
(171, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01549, '2024-05-25 14:08:53'),
(172, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.0378, '2024-05-25 14:08:59'),
(173, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01182, '2024-05-25 14:08:59'),
(174, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:09:01'),
(175, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.00872, '2024-05-25 14:09:01'),
(176, 1, '127.0.0.1', 'df?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:09:05'),
(177, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01091, '2024-05-25 14:09:05'),
(178, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01418, '2024-05-25 14:09:06'),
(179, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01565, '2024-05-25 14:09:07'),
(180, 1, '127.0.0.1', 'df/search?uri=df_documents-incoming_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.00988, '2024-05-25 14:09:08'),
(181, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:09:10'),
(182, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.0094, '2024-05-25 14:09:10'),
(183, 1, '127.0.0.1', 'df/documents-incoming/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:09:12'),
(184, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00837, '2024-05-25 14:09:12'),
(185, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01875, '2024-05-25 14:09:13'),
(186, 1, '127.0.0.1', 'df/search?uri=df_documents-outgoing_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01039, '2024-05-25 14:09:17'),
(187, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:09:20'),
(188, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.00883, '2024-05-25 14:09:20'),
(189, 1, '127.0.0.1', 'df/documents-outgoing/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:09:23'),
(190, 1, '127.0.0.1', 'df/documents-outgoing/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00933, '2024-05-25 14:09:23'),
(191, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.01469, '2024-05-25 14:09:28'),
(192, 1, '127.0.0.1', 'df/search?uri=df_documents-internal_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01277, '2024-05-25 14:09:33'),
(193, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:09:35'),
(194, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.00946, '2024-05-25 14:09:35'),
(195, 1, '127.0.0.1', 'df/documents-internal/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:09:37'),
(196, 1, '127.0.0.1', 'df/documents-internal/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 17, 0.00873, '2024-05-25 14:09:37'),
(197, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01362, '2024-05-25 14:10:26'),
(198, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01419, '2024-05-25 14:14:08'),
(199, 1, '127.0.0.1', 'df/search?uri=df_search', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.01035, '2024-05-25 14:14:19'),
(200, 1, '127.0.0.1', 'df/search?uri=df_search', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 11, 0.02896, '2024-05-25 14:14:37'),
(201, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01048, '2024-05-25 14:14:42'),
(202, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01259, '2024-05-25 14:14:43'),
(203, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.0117, '2024-05-25 14:17:32'),
(204, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01096, '2024-05-25 14:19:18'),
(205, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01037, '2024-05-25 14:19:33'),
(206, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01443, '2024-05-25 14:22:42'),
(207, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01157, '2024-05-25 14:22:47'),
(208, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:23:39'),
(209, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:24:12'),
(210, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 14:24:12'),
(211, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:02:50'),
(212, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:14:42'),
(213, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:16:09'),
(214, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:17:03'),
(215, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 5, 0.00557, '2024-05-25 15:17:03'),
(216, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 9, 0.0069, '2024-05-25 15:17:03'),
(217, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:17:06'),
(218, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 9, 0.00659, '2024-05-25 15:17:06'),
(219, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01454, '2024-05-25 15:17:11'),
(220, 1, '127.0.0.1', 'df?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:17:13'),
(221, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00831, '2024-05-25 15:17:13'),
(222, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01545, '2024-05-25 15:17:18'),
(223, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:17:32'),
(224, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01173, '2024-05-25 15:17:32'),
(225, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01796, '2024-05-25 15:17:42'),
(226, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01379, '2024-05-25 15:18:13'),
(227, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:18:19'),
(228, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01299, '2024-05-25 15:20:11'),
(229, 1, '127.0.0.1', 'df/documents-incoming/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:20:12'),
(230, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01003, '2024-05-25 15:20:12'),
(231, 1, '127.0.0.1', 'df/search?uri=df_documents-incoming_list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01284, '2024-05-25 15:20:15'),
(232, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:20:25'),
(233, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 15, 0.01469, '2024-05-25 15:20:25'),
(234, 1, '127.0.0.1', 'df/documents-incoming/list?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:21:19'),
(235, 1, '127.0.0.1', 'df/documents-incoming/list', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00964, '2024-05-25 15:21:19'),
(236, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.016, '2024-05-25 15:30:08'),
(237, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01015, '2024-05-25 15:31:32'),
(238, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:31:44'),
(239, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:31:44'),
(240, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:35:32'),
(241, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01271, '2024-05-25 15:37:11'),
(242, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:37:38'),
(243, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:38:07'),
(244, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:38:58'),
(245, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.02021, '2024-05-25 15:39:06'),
(246, 1, '127.0.0.1', 'df?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:39:10'),
(247, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.0096, '2024-05-25 15:39:10'),
(248, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.00836, '2024-05-25 15:39:12'),
(249, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:39:20'),
(250, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00823, '2024-05-25 15:39:20'),
(251, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:39:26'),
(252, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:40:43'),
(253, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:40:49'),
(254, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:51:02'),
(255, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:51:12'),
(256, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:51:21'),
(257, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:51:33'),
(258, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:51:59'),
(259, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:52:16'),
(260, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:52:48'),
(261, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:53:01'),
(262, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:53:02'),
(263, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:53:47'),
(264, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:54:09'),
(265, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:54:19'),
(266, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:54:39'),
(267, 0, '127.0.0.1', 'user/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 5, 0.00513, '2024-05-25 15:54:39'),
(268, 0, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 9, 0.00634, '2024-05-25 15:54:39'),
(269, 0, '127.0.0.1', 'user/login', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:54:42'),
(270, 1, '127.0.0.1', '', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 9, 0.0075, '2024-05-25 15:54:42'),
(271, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01386, '2024-05-25 15:54:45'),
(272, 1, '127.0.0.1', 'df?clear=y', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:54:46'),
(273, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01015, '2024-05-25 15:54:46'),
(274, 1, '127.0.0.1', 'df/search?uri=df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 12, 0.01326, '2024-05-25 15:54:48');
INSERT INTO `df_visitor_routes` (`vr_id`, `vr_id_user`, `vr_ip`, `vr_uri`, `vr_user_agent`, `vr_queries_count`, `vr_execution_time`, `vr_add_date`) VALUES
(275, 1, '127.0.0.1', 'df/search/handler', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 4, 0, '2024-05-25 15:54:56'),
(276, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.00998, '2024-05-25 15:54:56'),
(277, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01222, '2024-05-25 15:55:03'),
(278, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01547, '2024-05-25 15:55:14'),
(279, 1, '127.0.0.1', 'df', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 19, 0.01402, '2024-05-25 15:55:18');

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
-- Индексы таблицы `df_document_carrier_types`
--
ALTER TABLE `df_document_carrier_types`
  ADD PRIMARY KEY (`cts_id`);

--
-- Индексы таблицы `df_document_control_types`
--
ALTER TABLE `df_document_control_types`
  ADD PRIMARY KEY (`dct_id`),
  ADD UNIQUE KEY `uni_1` (`dct_name`);

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
-- Индексы таблицы `df_document_senders`
--
ALTER TABLE `df_document_senders`
  ADD PRIMARY KEY (`dss_id`),
  ADD UNIQUE KEY `uni_1` (`dss_name`);

--
-- Индексы таблицы `df_document_statuses`
--
ALTER TABLE `df_document_statuses`
  ADD PRIMARY KEY (`dst_id`),
  ADD UNIQUE KEY `uni_1` (`dst_name`);

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
  ADD UNIQUE KEY `uni_1` (`inr_number`);

--
-- Индексы таблицы `df_outgoing_documents_registry`
--
ALTER TABLE `df_outgoing_documents_registry`
  ADD PRIMARY KEY (`odr_id`),
  ADD UNIQUE KEY `uni_1` (`odr_number`),
  ADD KEY `odr_registration_form_number` (`odr_registration_form_number`);

--
-- Индексы таблицы `df_registration_forms`
--
ALTER TABLE `df_registration_forms`
  ADD PRIMARY KEY (`rf_id`),
  ADD UNIQUE KEY `uni_1` (`rf_name`);

--
-- Индексы таблицы `df_terms_of_execution`
--
ALTER TABLE `df_terms_of_execution`
  ADD PRIMARY KEY (`toe_id`),
  ADD UNIQUE KEY `uni_1` (`toe_name`);

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
  MODIFY `dp_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `df_distribution_scopes`
--
ALTER TABLE `df_distribution_scopes`
  MODIFY `dsc_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_carrier_types`
--
ALTER TABLE `df_document_carrier_types`
  MODIFY `cts_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `df_document_control_types`
--
ALTER TABLE `df_document_control_types`
  MODIFY `dct_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `df_document_descriptions`
--
ALTER TABLE `df_document_descriptions`
  MODIFY `dds_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `df_document_locations`
--
ALTER TABLE `df_document_locations`
  MODIFY `dlc_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `df_document_resolutions`
--
ALTER TABLE `df_document_resolutions`
  MODIFY `drs_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `df_document_senders`
--
ALTER TABLE `df_document_senders`
  MODIFY `dss_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `df_document_statuses`
--
ALTER TABLE `df_document_statuses`
  MODIFY `dst_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `df_document_titles`
--
ALTER TABLE `df_document_titles`
  MODIFY `dts_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `df_document_types`
--
ALTER TABLE `df_document_types`
  MODIFY `dt_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `df_incoming_documents_registry`
--
ALTER TABLE `df_incoming_documents_registry`
  MODIFY `idr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `df_internal_documents_registry`
--
ALTER TABLE `df_internal_documents_registry`
  MODIFY `inr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `df_outgoing_documents_registry`
--
ALTER TABLE `df_outgoing_documents_registry`
  MODIFY `odr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `df_registration_forms`
--
ALTER TABLE `df_registration_forms`
  MODIFY `rf_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `df_terms_of_execution`
--
ALTER TABLE `df_terms_of_execution`
  MODIFY `toe_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `df_users`
--
ALTER TABLE `df_users`
  MODIFY `us_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `df_users_rel_statuses`
--
ALTER TABLE `df_users_rel_statuses`
  MODIFY `usr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
  MODIFY `vr_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

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
-- Ограничения внешнего ключа таблицы `df_outgoing_documents_registry`
--
ALTER TABLE `df_outgoing_documents_registry`
  ADD CONSTRAINT `odr_registration_form_number` FOREIGN KEY (`odr_registration_form_number`) REFERENCES `df_registration_forms` (`rf_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `df_users_rel_statuses`
--
ALTER TABLE `df_users_rel_statuses`
  ADD CONSTRAINT `usr_status` FOREIGN KEY (`usr_id_status`) REFERENCES `df_user_statuses` (`uss_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `usr_user` FOREIGN KEY (`usr_id_user`) REFERENCES `df_users` (`us_id`);

--
-- Ограничения внешнего ключа таблицы `df_user_rel_departament`
--
ALTER TABLE `df_user_rel_departament`
  ADD CONSTRAINT `urd_departament` FOREIGN KEY (`urd_id_departament`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `urd_user` FOREIGN KEY (`urd_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
