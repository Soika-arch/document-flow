CREATE TABLE `df_document_titles` (
  `dts_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dts_id_user` bigint unsigned NOT NULL,
  `dts_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dts_add_date` datetime NOT NULL,
  `dts_change_date` datetime NOT NULL,
  PRIMARY KEY (`dts_id`),
  KEY `dts_user` (`dts_id_user`),
  CONSTRAINT `dts_user` FOREIGN KEY (`dts_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Назви або заголовоки документів';

INSERT INTO `df_document_titles` VALUES ('1', '1', 'Заява про постачання продукції', '2024-05-17 14:15:53', '2024-05-17 14:15:53');
INSERT INTO `df_document_titles` VALUES ('2', '1', 'Лист про погодження умов договору', '2024-05-17 14:15:53', '2024-05-17 14:15:53');
INSERT INTO `df_document_titles` VALUES ('3', '1', 'Запит на надання інформації', '2024-05-17 14:15:53', '2024-05-17 14:15:53');
INSERT INTO `df_document_titles` VALUES ('4', '1', 'Претензійний лист', '2024-05-17 14:15:53', '2024-05-17 14:15:53');
INSERT INTO `df_document_titles` VALUES ('5', '1', 'Повідомлення про зміну умов контракту', '2024-05-17 14:15:53', '2024-05-17 14:15:53');
INSERT INTO `df_document_titles` VALUES ('6', '1', 'Акт приймання виконаних робіт', '2024-05-17 14:15:53', '2024-05-17 14:15:53');
INSERT INTO `df_document_titles` VALUES ('7', '1', 'Договір поставки', '2024-05-17 14:15:53', '2024-05-17 14:15:53');
INSERT INTO `df_document_titles` VALUES ('8', '1', 'Рахунок-фактура', '2024-05-17 14:15:53', '2024-05-17 14:15:53');
INSERT INTO `df_document_titles` VALUES ('9', '1', 'Запрошення на ділову зустріч', '2024-05-17 14:15:53', '2024-05-17 14:15:53');
INSERT INTO `df_document_titles` VALUES ('10', '1', 'Накладна на постачання товарів', '2024-05-29 03:28:44', '2024-05-29 03:28:44');
INSERT INTO `df_document_titles` VALUES ('12', '1', 'Тестова назва документа', '2024-06-16 19:15:45', '2024-06-16 19:15:45');
