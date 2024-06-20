CREATE TABLE `df_user_document_access` (
  `uda_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uda_id_user` bigint unsigned NOT NULL COMMENT 'Користувач, який надав доступ',
  `uda_id_recipient` bigint unsigned NOT NULL,
  `uda_id_document` bigint unsigned NOT NULL,
  `uda_add_date` datetime NOT NULL,
  `uda_change_date` datetime NOT NULL,
  PRIMARY KEY (`uda_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Таблиця доступу до документів користувачів';

