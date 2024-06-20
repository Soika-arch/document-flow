CREATE TABLE `df_cron_tasks` (
  `crt_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `crt_task_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crt_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `crt_schedule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Унікальний розклад у форматі cron',
  `crt_is_active` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL,
  `crt_last_run` datetime DEFAULT NULL,
  `crt_next_run` datetime DEFAULT NULL,
  `crt_parameters` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crt_add_date` datetime NOT NULL,
  `crt_change_date` datetime NOT NULL,
  PRIMARY KEY (`crt_id`),
  UNIQUE KEY `uni_1` (`crt_task_name`),
  UNIQUE KEY `uni_2` (`crt_schedule`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Конфігурації cron задач';

INSERT INTO `df_cron_tasks` VALUES ('1', 't0001', 'Сповіщення користувачів про наявні непрочитані приватні повідомлення.', '0 7 * * *', 'y', '2024-06-09 11:16:43', '2024-06-10 07:00:00', '', '2024-06-05 12:19:01', '2024-06-09 11:16:43');
INSERT INTO `df_cron_tasks` VALUES ('2', 't0002', 'Сповіщення користувачів про контрольні дати документів.', '2 7 * * *', 'y', '', '', '', '2024-06-06 06:12:40', '2024-06-09 11:12:08');
INSERT INTO `df_cron_tasks` VALUES ('3', 't0003', 'Створення повного бекапа бази даних та відправлення архіву адміну на email.', '15 7 * * *', 'y', '', '', '', '2024-06-10 06:21:57', '2024-06-10 06:21:57');
