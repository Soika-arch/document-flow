CREATE TABLE `df_terms_of_execution` (
  `toe_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `toe_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `toe_days` tinyint NOT NULL,
  `toe_add_date` datetime NOT NULL,
  `toe_change_date` datetime NOT NULL,
  PRIMARY KEY (`toe_id`),
  UNIQUE KEY `uni_1` (`toe_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Терміни виконання для різних типів за контролем виконання';

INSERT INTO `df_terms_of_execution` VALUES ('1', 'Стандартний', '10', '2024-05-19 13:25:17', '2024-05-19 13:25:17');
INSERT INTO `df_terms_of_execution` VALUES ('2', 'Терміновий', '3', '2024-05-19 13:25:17', '2024-05-19 13:25:17');
