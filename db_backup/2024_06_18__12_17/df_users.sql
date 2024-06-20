CREATE TABLE `df_users` (
  `us_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `us_login` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `us_password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `us_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `us_id_tg` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Telegram id',
  `us_change_date` datetime DEFAULT NULL,
  `us_add_date` datetime NOT NULL,
  PRIMARY KEY (`us_id`),
  UNIQUE KEY `uni_1` (`us_login`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `df_users` VALUES ('0', 'Guest', '', '', '', '2024-05-30 21:45:11', '2024-04-14 16:05:13');
INSERT INTO `df_users` VALUES ('1', 'Admin', '$2y$10$vEIigCI0EotxwtiXyhE8V.fTo6CgjQhhK78zPWlYwm8XV17WTdkYu', 'vladimirovichser@gmail.com\n', '794375162', '2024-05-23 20:17:26', '2024-04-14 16:05:13');
INSERT INTO `df_users` VALUES ('47', 'Dvemerixs', '$2y$10$6BTC4Yv/oQU38ZXnP3h1UexK0QiDN10ERNds44dMRVhpvkLddDwlu', 'test2@gmail.com', '', '2024-05-24 21:51:24', '2024-05-13 16:13:37');
INSERT INTO `df_users` VALUES ('50', 'Dvemerix_user', '$2y$10$NujZEa58r1.eCEYNwbY4f.7eqhXR61pfLRkSIoclL8MRgAd5UjYki', 'test1@gmail.com', '', '2024-05-23 20:17:33', '2024-05-19 14:21:00');
INSERT INTO `df_users` VALUES ('51', 'Dvemerix_viewer', '$2y$10$lMtdtFye.IsvStLAJ8yhDOCin2uocWWRW0/vzjjJxyx6TqQ9eNPPy', 'test3@gmail.com', '', '2024-05-23 20:17:35', '2024-05-19 14:26:18');
INSERT INTO `df_users` VALUES ('59', 'Soika', '$2y$10$ty2fw3KUzQS7yWD81rhGZeJUVv2ZcbgrX18DISPgZ2E2GQCLdyjMq', '', '602635770', '', '2024-06-02 16:14:00');
INSERT INTO `df_users` VALUES ('77', 'manager_user', '$2y$10$m9msMIu.IfClkHWgLaoCAOgeMXfwsb/pFBvhz45X7EADy3QRi5SS.', 'zorkiysv1@gmail.com', '', '2024-06-03 10:22:37', '2024-06-03 10:21:20');
INSERT INTO `df_users` VALUES ('79', 'Registrar_user_1', '$2y$10$Wx9bN7fCibGeQftuXyTZAOwgqDMWGMihyANpUoin3VepojRKlEJQm', 'zorkiysv3@gmail.com', '', '2024-06-15 15:14:01', '2024-06-09 07:22:31');
INSERT INTO `df_users` VALUES ('80', 'Registrar_user_2', '$2y$10$XNJXDCty8ieECkj6kV7BjORQ1aRsv2UJJP0ZS4HfA0ihKocSDueq.', 'zorkiysv2@gmail.com', '', '', '2024-06-15 15:14:40');
