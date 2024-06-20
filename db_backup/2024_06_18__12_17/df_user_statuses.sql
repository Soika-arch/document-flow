CREATE TABLE `df_user_statuses` (
  `uss_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uss_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uss_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uss_access_level` tinyint NOT NULL COMMENT 'Числовий рівень доступу',
  `uss_add_date` datetime NOT NULL,
  PRIMARY KEY (`uss_id`),
  UNIQUE KEY `uni_1` (`uss_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Статуси користувачів модуля df_';

INSERT INTO `df_user_statuses` VALUES ('1', 'SuperAdmin', 'Супер адміністратор', '1', '2024-05-04 14:45:11');
INSERT INTO `df_user_statuses` VALUES ('2', 'Admin', 'Адміністратор', '2', '2024-04-24 19:29:50');
INSERT INTO `df_user_statuses` VALUES ('3', 'User', 'Користувач', '3', '2024-05-04 14:42:53');
INSERT INTO `df_user_statuses` VALUES ('4', 'Viewer', 'Переглядач', '4', '2024-05-04 14:44:17');
INSERT INTO `df_user_statuses` VALUES ('5', 'Guest', 'Гість', '5', '2024-04-24 19:32:08');
