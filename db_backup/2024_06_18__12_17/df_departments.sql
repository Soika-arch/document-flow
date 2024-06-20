CREATE TABLE `df_departments` (
  `dp_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dp_id_user` bigint unsigned NOT NULL,
  `dp_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Назва відділу',
  `dp_add_date` datetime NOT NULL,
  `dp_change_date` datetime NOT NULL,
  PRIMARY KEY (`dp_id`),
  KEY `dp_user` (`dp_id_user`),
  CONSTRAINT `dp_user` FOREIGN KEY (`dp_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Відділи організації';

INSERT INTO `df_departments` VALUES ('1', '1', 'Відділ управління персоналом', '2024-05-16 11:48:18', '2024-05-16 11:48:18');
INSERT INTO `df_departments` VALUES ('2', '1', 'Фінансовий відділ', '2024-05-16 11:50:30', '2024-05-16 11:50:30');
INSERT INTO `df_departments` VALUES ('3', '1', 'Відділ інформаційних технологій', '2024-05-16 11:50:30', '2024-05-16 11:50:30');
INSERT INTO `df_departments` VALUES ('4', '1', 'Логістичний департамент', '2024-05-16 11:48:18', '2024-05-16 11:48:18');
INSERT INTO `df_departments` VALUES ('5', '1', 'Департамент операційної діяльності', '2024-05-16 11:48:18', '2024-05-16 11:48:18');
INSERT INTO `df_departments` VALUES ('6', '1', 'Департамент досліджень та розробок', '2024-05-16 11:48:18', '2024-05-16 11:48:18');
INSERT INTO `df_departments` VALUES ('7', '1', 'Департамент корпоративних комунікацій', '2024-05-16 11:48:18', '2024-05-16 11:48:18');
