CREATE TABLE `df_document_control_types` (
  `dct_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dct_id_user` bigint unsigned NOT NULL,
  `dct_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dct_seconds` bigint unsigned NOT NULL COMMENT 'Кількість секунд до дати контролю',
  `dct_add_date` datetime NOT NULL,
  `dct_change_date` datetime NOT NULL,
  PRIMARY KEY (`dct_id`),
  UNIQUE KEY `uni_1` (`dct_name`),
  KEY `dct_user` (`dct_id_user`),
  CONSTRAINT `dct_user` FOREIGN KEY (`dct_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Видів контролю за виконанням документів';

INSERT INTO `df_document_control_types` VALUES ('1', '1', 'Разово', '0', '2024-05-16 13:29:21', '2024-05-16 13:29:21');
INSERT INTO `df_document_control_types` VALUES ('2', '1', 'Щодня', '86400', '2024-05-16 13:29:21', '2024-05-16 13:29:21');
INSERT INTO `df_document_control_types` VALUES ('3', '1', 'Щотижня', '604800', '2024-05-16 13:29:57', '2024-05-16 13:29:57');
INSERT INTO `df_document_control_types` VALUES ('4', '1', 'Щомісяця', '2592000', '2024-05-16 13:29:57', '2024-05-16 13:29:57');
INSERT INTO `df_document_control_types` VALUES ('7', '1', 'Щорічно', '31536000', '2024-05-16 13:29:57', '2024-05-16 13:29:57');
