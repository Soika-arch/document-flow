CREATE TABLE `df_user_messages` (
  `usm_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usm_id_user` bigint unsigned NOT NULL,
  `usm_id_sender` bigint unsigned NOT NULL,
  `usm_header` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usm_msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usm_read` enum('y','n') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `usm_trash_bin` enum('y','n') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `usm_add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usm_change_date` datetime DEFAULT NULL,
  PRIMARY KEY (`usm_id`),
  KEY `usm_id_user` (`usm_id_user`),
  KEY `usm_id_sender` (`usm_id_sender`),
  CONSTRAINT `usm_sender` FOREIGN KEY (`usm_id_sender`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `usm_user` FOREIGN KEY (`usm_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Приватні повідомлення користувачів';

INSERT INTO `df_user_messages` VALUES ('1', '50', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000001\" target=\"_blank\">Накладна на постачання товарів</a>', 'y', 'n', '2024-06-01 16:35:36', '2024-06-01 17:25:02');
INSERT INTO `df_user_messages` VALUES ('2', '47', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000001\" target=\"_blank\">Накладна на постачання товарів</a>', 'y', 'n', '2024-06-01 17:31:29', '2024-06-01 19:08:13');
INSERT INTO `df_user_messages` VALUES ('3', '50', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000001\" target=\"_blank\">Накладна на постачання товарів</a>', 'y', 'n', '2024-06-01 17:31:52', '2024-06-01 18:58:19');
INSERT INTO `df_user_messages` VALUES ('4', '50', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-internal/card?n=00000001\">Запит на надання інформації</a>', 'y', 'n', '2024-06-01 19:19:24', '2024-06-01 19:20:02');
INSERT INTO `df_user_messages` VALUES ('5', '1', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000006\">Запит на надання інформації</a>', 'y', 'n', '2024-06-02 11:25:47', '2024-06-02 14:22:52');
INSERT INTO `df_user_messages` VALUES ('6', '47', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000001\">Накладна на постачання товарів</a>', 'n', 'n', '2024-06-02 14:42:23', '2024-06-02 14:42:23');
INSERT INTO `df_user_messages` VALUES ('8', '59', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000004\">Запит на надання інформації</a>', 'y', 'n', '2024-06-02 16:17:07', '2024-06-02 16:23:24');
INSERT INTO `df_user_messages` VALUES ('9', '50', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000001\">Накладна на постачання товарів</a>', 'n', 'n', '2024-06-03 09:38:38', '2024-06-03 09:38:38');
INSERT INTO `df_user_messages` VALUES ('11', '50', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000004\">Запит на надання інформації</a>', 'n', 'n', '2024-06-03 10:52:26', '2024-06-03 10:52:26');
INSERT INTO `df_user_messages` VALUES ('12', '59', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000004\">Запит на надання інформації</a>', 'n', 'n', '2024-06-03 10:58:33', '2024-06-03 10:58:33');
INSERT INTO `df_user_messages` VALUES ('13', '1', '1', '<span class=\"msg-header-warning\">Контрольна дата документа</span>', 'Сьогодні контрольна дата документа <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000001\">INC_00000001</a>', 'y', 'n', '2024-06-03 22:28:58', '2024-06-03 22:29:05');
INSERT INTO `df_user_messages` VALUES ('21', '59', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000001\">Накладна на постачання товарів</a>', 'n', 'n', '2024-06-06 15:19:22', '2024-06-06 15:19:22');
INSERT INTO `df_user_messages` VALUES ('22', '1', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-internal/card?n=00000002\">Заява про постачання продукції</a>', 'y', 'n', '2024-06-08 06:41:58', '2024-06-11 09:45:49');
INSERT INTO `df_user_messages` VALUES ('23', '59', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-internal/card?n=00000002\">Заява про постачання продукції</a>', 'n', 'n', '2024-06-09 08:53:44', '2024-06-09 08:53:44');
INSERT INTO `df_user_messages` VALUES ('24', '50', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000001\">Накладна на постачання товарів</a>', 'n', 'n', '2024-06-11 09:45:39', '2024-06-11 09:45:39');
INSERT INTO `df_user_messages` VALUES ('25', '1', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000001\">Накладна на постачання товарів</a>', 'y', 'n', '2024-06-14 18:18:37', '2024-06-14 18:23:12');
INSERT INTO `df_user_messages` VALUES ('26', '59', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000009\">Заява про постачання продукції</a>', 'n', 'n', '2024-06-14 18:27:36', '2024-06-14 18:27:36');
INSERT INTO `df_user_messages` VALUES ('27', '1', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000010\">Заява про постачання продукції</a>', 'n', 'n', '2024-06-17 21:44:38', '2024-06-17 21:44:38');
INSERT INTO `df_user_messages` VALUES ('28', '50', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000010\">Заява про постачання продукції</a>', 'n', 'n', '2024-06-17 21:58:01', '2024-06-17 21:58:01');
INSERT INTO `df_user_messages` VALUES ('29', '47', '1', 'Призначено новий документ на виконання', 'Вам призначено новий документ на виконання: <a href=\"http://document-flow.loc/df/documents-incoming/card?n=00000010\">Заява про постачання продукції</a>', 'n', 'n', '2024-06-17 22:00:44', '2024-06-17 22:00:44');
