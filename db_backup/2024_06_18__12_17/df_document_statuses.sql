CREATE TABLE `df_document_statuses` (
  `dst_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dst_id_user` bigint unsigned NOT NULL COMMENT 'Користовач, який створив статус',
  `dst_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dst_add_date` datetime NOT NULL,
  `dst_change_date` datetime NOT NULL,
  PRIMARY KEY (`dst_id`),
  UNIQUE KEY `uni_1` (`dst_name`),
  KEY `dst_user` (`dst_id_user`),
  CONSTRAINT `dst_user` FOREIGN KEY (`dst_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Статуси документів (новий, в обробці ...)';

INSERT INTO `df_document_statuses` VALUES ('1', '1', 'Новий', '2024-05-16 11:19:58', '2024-05-16 11:19:58');
INSERT INTO `df_document_statuses` VALUES ('2', '1', 'В обробці', '2024-05-16 11:20:09', '2024-05-16 11:20:09');
