CREATE TABLE `df_document_resolutions` (
  `drs_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `drs_id_user` bigint unsigned NOT NULL,
  `drs_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `drs_add_date` datetime NOT NULL,
  `drs_change_date` datetime NOT NULL,
  PRIMARY KEY (`drs_id`),
  KEY `drs_user` (`drs_id_user`),
  CONSTRAINT `drs_user` FOREIGN KEY (`drs_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Резолюції документів';

INSERT INTO `df_document_resolutions` VALUES ('1', '1', 'До виконання', '2024-05-16 12:25:57', '2024-05-16 12:25:57');
INSERT INTO `df_document_resolutions` VALUES ('2', '1', 'На контроль', '2024-05-16 12:25:57', '2024-05-16 12:25:57');
INSERT INTO `df_document_resolutions` VALUES ('3', '1', 'До відома', '2024-05-16 12:27:17', '2024-05-16 12:27:17');
INSERT INTO `df_document_resolutions` VALUES ('4', '1', 'На узгодження', '2024-05-16 12:27:17', '2024-05-16 12:27:17');
