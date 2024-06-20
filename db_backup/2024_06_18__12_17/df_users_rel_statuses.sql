CREATE TABLE `df_users_rel_statuses` (
  `usr_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usr_id_user` bigint unsigned NOT NULL,
  `usr_id_status` bigint unsigned NOT NULL,
  `usr_add_date` datetime NOT NULL,
  `usr_change_date` datetime NOT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `uni_1` (`usr_id_user`,`usr_id_status`),
  KEY `usr_status` (`usr_id_status`),
  CONSTRAINT `usr_status` FOREIGN KEY (`usr_id_status`) REFERENCES `df_user_statuses` (`uss_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `usr_user` FOREIGN KEY (`usr_id_user`) REFERENCES `df_users` (`us_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Зв''язки користувачів з їх статусами';

INSERT INTO `df_users_rel_statuses` VALUES ('1', '1', '1', '2024-04-24 19:30:41', '2024-04-24 19:30:41');
INSERT INTO `df_users_rel_statuses` VALUES ('29', '50', '3', '2024-05-19 14:21:00', '2024-05-19 14:21:00');
INSERT INTO `df_users_rel_statuses` VALUES ('30', '51', '4', '2024-05-19 14:26:18', '2024-05-19 14:26:18');
INSERT INTO `df_users_rel_statuses` VALUES ('35', '47', '3', '2024-05-24 21:51:24', '2024-05-24 21:51:24');
INSERT INTO `df_users_rel_statuses` VALUES ('37', '0', '5', '2024-05-30 21:45:11', '2024-05-30 21:45:11');
INSERT INTO `df_users_rel_statuses` VALUES ('39', '59', '1', '2024-04-24 19:30:41', '2024-04-24 19:30:41');
INSERT INTO `df_users_rel_statuses` VALUES ('47', '77', '3', '2024-06-03 10:22:37', '2024-06-03 10:22:37');
INSERT INTO `df_users_rel_statuses` VALUES ('50', '79', '4', '2024-06-15 15:13:50', '2024-06-15 15:13:50');
INSERT INTO `df_users_rel_statuses` VALUES ('51', '80', '4', '2024-06-15 15:14:40', '2024-06-15 15:14:40');
