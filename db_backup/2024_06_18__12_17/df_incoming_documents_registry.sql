CREATE TABLE `df_incoming_documents_registry` (
  `idr_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `idr_id_user` bigint unsigned NOT NULL COMMENT 'Користувач, який зареєстрував документ',
  `idr_id_document_type` bigint unsigned NOT NULL COMMENT 'Тип документа',
  `idr_id_carrier_type` bigint unsigned NOT NULL COMMENT 'Тип носія документа',
  `idr_id_document_location` bigint unsigned DEFAULT NULL COMMENT 'Відділ фізичного місцезнаходження оригінала',
  `idr_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Номер вхідного документа',
  `idr_id_outgoing_number` bigint unsigned DEFAULT NULL COMMENT 'Номер відповідного вихідного',
  `idr_id_title` bigint unsigned NOT NULL COMMENT 'Назва чи заголовок документа',
  `idr_document_date` date DEFAULT NULL COMMENT 'Дата в документі',
  `idr_id_recipient` bigint unsigned DEFAULT NULL COMMENT 'Отримувач (користувач)',
  `idr_id_sender` bigint unsigned DEFAULT NULL COMMENT 'Відправник документу (зовнішній)',
  `idr_id_description` bigint unsigned DEFAULT NULL COMMENT 'Опис або короткий зміст документа',
  `idr_file_extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Розширення файлу завантаженого документа',
  `idr_id_status` bigint unsigned DEFAULT NULL COMMENT 'Статус документа (наприклад, "новий", "в обробці", "завершено")',
  `idr_id_responsible_user` bigint unsigned DEFAULT NULL COMMENT 'id відповідального за виконання',
  `idr_id_assigned_user` bigint unsigned DEFAULT NULL COMMENT 'Призначений користувач обробки документа.',
  `idr_id_assigned_departament` bigint unsigned DEFAULT NULL COMMENT 'id відділа, якому призначено на виконання',
  `idr_id_resolution` bigint unsigned DEFAULT NULL COMMENT 'Резолюція',
  `idr_resolution_date` datetime DEFAULT NULL COMMENT 'Дата призначення резолюції',
  `idr_date_of_receipt_by_executor` datetime DEFAULT NULL COMMENT 'Дата надходження виконавцю',
  `idr_id_execution_control` bigint unsigned DEFAULT NULL COMMENT 'Контроль виконання: one-time, monthly, quarterly, annually',
  `idr_id_term_of_execution` bigint unsigned DEFAULT NULL COMMENT 'Термін виконання в днях',
  `idr_control_date` datetime DEFAULT NULL COMMENT 'Дата, до якої документ має бути виконаним',
  `idr_execution_date` datetime DEFAULT NULL COMMENT 'Дата виконання документа',
  `idr_trash_bin` datetime DEFAULT NULL COMMENT 'Чи перенесено документ у корзину',
  `idr_add_date` datetime NOT NULL,
  `idr_change_date` datetime NOT NULL,
  PRIMARY KEY (`idr_id`),
  UNIQUE KEY `uni_1` (`idr_number`),
  KEY `idr_document_format` (`idr_id_carrier_type`),
  KEY `idr_assigned_departament` (`idr_id_assigned_departament`),
  KEY `idr_description` (`idr_id_description`),
  KEY `idr_document_type` (`idr_id_document_type`),
  KEY `idr_outgoing_number` (`idr_id_outgoing_number`),
  KEY `idr_resolution` (`idr_id_resolution`),
  KEY `idr_responsible_user` (`idr_id_responsible_user`),
  KEY `idr_sender` (`idr_id_sender`),
  KEY `idr_status` (`idr_id_status`),
  KEY `idr_title` (`idr_id_title`),
  KEY `idr_user` (`idr_id_user`),
  KEY `idr_document_location` (`idr_id_document_location`),
  KEY `idr_assigned_user` (`idr_id_assigned_user`),
  KEY `idr_execution_control` (`idr_id_execution_control`),
  KEY `idr_term_of_execution` (`idr_id_term_of_execution`),
  KEY `idr_recipient` (`idr_id_recipient`),
  CONSTRAINT `idr_assigned_departament` FOREIGN KEY (`idr_id_assigned_departament`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_assigned_user` FOREIGN KEY (`idr_id_assigned_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_description` FOREIGN KEY (`idr_id_description`) REFERENCES `df_document_descriptions` (`dds_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_document_format` FOREIGN KEY (`idr_id_carrier_type`) REFERENCES `df_document_carrier_types` (`cts_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_document_location` FOREIGN KEY (`idr_id_document_location`) REFERENCES `df_departments` (`dp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_document_type` FOREIGN KEY (`idr_id_document_type`) REFERENCES `df_document_types` (`dt_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_execution_control` FOREIGN KEY (`idr_id_execution_control`) REFERENCES `df_document_control_types` (`dct_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_outgoing_number` FOREIGN KEY (`idr_id_outgoing_number`) REFERENCES `df_outgoing_documents_registry` (`odr_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_recipient` FOREIGN KEY (`idr_id_recipient`) REFERENCES `df_users` (`us_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `idr_resolution` FOREIGN KEY (`idr_id_resolution`) REFERENCES `df_document_resolutions` (`drs_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_responsible_user` FOREIGN KEY (`idr_id_responsible_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_sender` FOREIGN KEY (`idr_id_sender`) REFERENCES `df_document_senders` (`dss_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_status` FOREIGN KEY (`idr_id_status`) REFERENCES `df_document_statuses` (`dst_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_term_of_execution` FOREIGN KEY (`idr_id_term_of_execution`) REFERENCES `df_terms_of_execution` (`toe_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_title` FOREIGN KEY (`idr_id_title`) REFERENCES `df_document_titles` (`dts_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `idr_user` FOREIGN KEY (`idr_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Регістр вхідних документів із основними даними';

INSERT INTO `df_incoming_documents_registry` VALUES ('1', '1', '1', '1', '4', '00000001', '1', '10', '2024-05-02', '1', '4', '13', 'sql', '1', '50', '1', '1', '', '', '2024-06-17 00:00:00', '3', '1', '', '', '', '2024-05-01 00:00:00', '2024-06-17 18:18:16');
INSERT INTO `df_incoming_documents_registry` VALUES ('2', '50', '1', '1', '', '00000002', '', '3', '2024-05-27', '50', '1', '1', 'torrent', '1', '50', '47', '1', '1', '2024-06-15 19:25:37', '', '', '', '', '2024-06-07 00:00:00', '', '2024-05-27 00:00:00', '2024-06-15 19:25:37');
INSERT INTO `df_incoming_documents_registry` VALUES ('3', '1', '4', '1', '3', '00000003', '', '2', '2021-05-27', '50', '1', '1', 'jpg', '1', '50', '50', '2', '1', '', '', '1', '', '2024-05-30 00:00:00', '', '', '2024-05-27 00:00:00', '2024-06-01 14:45:47');
INSERT INTO `df_incoming_documents_registry` VALUES ('4', '1', '1', '2', '2', '00000004', '', '3', '2022-11-13', '47', '1', '1', 'png', '2', '47', '59', '2', '2', '', '', '3', '1', '2024-06-29 00:00:00', '', '', '2024-05-27 00:00:00', '2024-06-17 14:00:35');
INSERT INTO `df_incoming_documents_registry` VALUES ('5', '59', '1', '1', '', '00000005', '', '1', '2024-05-27', '1', '2', '1', 'png', '1', '1', '', '1', '1', '2024-06-15 19:12:06', '', '3', '', '', '', '2024-06-17 13:01:49', '2024-05-27 00:00:00', '2024-06-16 17:29:37');
INSERT INTO `df_incoming_documents_registry` VALUES ('6', '1', '9', '1', '1', '00000006', '', '3', '2024-05-27', '47', '1', '1', 'png', '1', '1', '1', '1', '1', '2024-06-03 11:53:24', '2024-06-02 00:00:00', '3', '', '', '2024-06-08 00:00:00', '', '2024-05-27 00:00:00', '2024-06-08 06:51:24');
INSERT INTO `df_incoming_documents_registry` VALUES ('7', '1', '13', '2', '2', '00000007', '1', '2', '2024-04-30', '47', '1', '1', 'docx', '2', '47', '47', '2', '3', '', '', '1', '2', '', '', '', '2024-05-28 16:07:13', '2024-05-28 16:07:13');
INSERT INTO `df_incoming_documents_registry` VALUES ('8', '1', '12', '1', '3', '00000008', '', '3', '2024-05-10', '1', '1', '1', 'sql', '1', '1', '', '3', '3', '', '', '', '2', '', '', '', '2024-05-28 16:23:03', '2024-05-28 16:23:03');
INSERT INTO `df_incoming_documents_registry` VALUES ('9', '1', '13', '1', '2', '00000009', '', '1', '2024-05-13', '50', '1', '1', 'png', '2', '50', '59', '2', '4', '', '', '2', '1', '2024-06-13 00:00:00', '', '', '2024-05-28 00:00:00', '2024-06-14 18:27:36');
INSERT INTO `df_incoming_documents_registry` VALUES ('10', '1', '14', '1', '2', '00000010', '', '1', '2023-02-15', '50', '1', '1', 'jpg', '2', '59', '47', '2', '4', '', '', '', '', '', '', '', '2024-05-28 00:00:00', '2024-06-17 22:00:56');
INSERT INTO `df_incoming_documents_registry` VALUES ('11', '1', '14', '1', '2', '00000011', '', '1', '2023-07-09', '50', '1', '1', 'png', '2', '50', '', '2', '4', '', '', '', '', '', '', '', '2024-05-28 16:42:52', '2024-05-28 16:42:52');
INSERT INTO `df_incoming_documents_registry` VALUES ('12', '1', '2', '3', '4', '00000012', '', '2', '2024-06-15', '50', '1', '12', 'png', '2', '50', '77', '4', '1', '', '', '3', '1', '', '', '2024-06-17 13:02:13', '2024-06-15 15:45:44', '2024-06-15 15:45:44');
