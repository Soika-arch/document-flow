CREATE TABLE `df_user_rel_departament` (
  `urd_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `urd_id_user` bigint unsigned NOT NULL,
  `urd_id_departament` bigint unsigned NOT NULL,
  `urd_add_date` datetime NOT NULL,
  `urd_change_date` datetime NOT NULL,
  PRIMARY KEY (`urd_id`),
  KEY `urd_user` (`urd_id_user`),
  KEY `urd_departament` (`urd_id_departament`),
  CONSTRAINT `urd_departament` FOREIGN KEY (`urd_id_departament`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `urd_user` FOREIGN KEY (`urd_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Зв''язки користувачів з департаментами';

