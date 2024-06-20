CREATE TABLE `df_document_carrier_types` (
  `cts_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cts_id_user` bigint unsigned NOT NULL,
  `cts_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cts_add_date` datetime NOT NULL,
  `cts_change_date` datetime NOT NULL,
  PRIMARY KEY (`cts_id`),
  KEY `cts_user` (`cts_id_user`),
  CONSTRAINT `cts_user` FOREIGN KEY (`cts_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Можливі типи носіів документів';

INSERT INTO `df_document_carrier_types` VALUES ('1', '1', 'Електронний носій', '2024-05-16 10:39:58', '2024-05-16 10:39:58');
INSERT INTO `df_document_carrier_types` VALUES ('2', '1', 'Паперовий носій', '2024-05-16 10:39:58', '2024-05-16 10:39:58');
INSERT INTO `df_document_carrier_types` VALUES ('3', '1', 'Мікрофільм', '2024-05-16 10:39:58', '2024-05-16 10:39:58');
INSERT INTO `df_document_carrier_types` VALUES ('4', '1', 'Факс', '2024-05-16 10:39:58', '2024-05-16 10:39:58');
INSERT INTO `df_document_carrier_types` VALUES ('5', '1', 'Телефонограма', '2024-05-28 13:32:41', '2024-05-28 13:32:41');
