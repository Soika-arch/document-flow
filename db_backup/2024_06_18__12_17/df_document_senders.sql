CREATE TABLE `df_document_senders` (
  `dss_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dss_id_user` bigint unsigned DEFAULT NULL,
  `dss_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Назва організації / ФІО',
  `dss_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dss_phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dss_address` text COLLATE utf8mb4_unicode_ci,
  `dss_legal_address` text COLLATE utf8mb4_unicode_ci COMMENT 'Юридична адреса',
  `dss_add_date` datetime NOT NULL,
  `dss_change_date` datetime NOT NULL,
  PRIMARY KEY (`dss_id`),
  UNIQUE KEY `uni_1` (`dss_name`),
  KEY `dss_user` (`dss_id_user`),
  CONSTRAINT `dss_user` FOREIGN KEY (`dss_id_user`) REFERENCES `df_users` (`us_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Дані відправників документів';

INSERT INTO `df_document_senders` VALUES ('1', '1', 'ТОВ \"ІнфоБезПрофі\"', 'contact@infobezprofi.ua', '380442345678', 'вул. Жилянська, 75, офіс 22, м. Київ, 01032, Україна', 'вул. Богдана Хмельницького, 50, офіс 18, м. Київ, 01030, Україна', '2024-05-17 13:06:39', '2024-05-17 13:06:39');
INSERT INTO `df_document_senders` VALUES ('2', '1', 'ТОВ \"Фінансовий Аудит\"', 'info@fin-audit.ua', '380441234567', 'вул. Шота Руставелі, 12, офіс 5, м. Київ, 01033, Україна', 'вул. Інститутська, 25, офіс 10, м. Київ, 01021, Україна', '2024-05-28 13:06:39', '2024-05-28 13:06:39');
INSERT INTO `df_document_senders` VALUES ('3', '1', 'ТОВ \"Правовий Захист\"', 'info@pravoviy-zahist.ua', '0888888888', 'вул. Велика Васильківська, 45, офіс 7, м. Київ, 03150, Україна', 'вул. Грушевського, 30, офіс 15, м. Київ, 01021, Україна', '2024-05-28 13:06:39', '2024-05-28 13:06:39');
INSERT INTO `df_document_senders` VALUES ('4', '1', 'ТОВ \"Смачні Продукти\"', 'info@smachni-produkty.ua', '0777777777', 'вул. Сагайдачного, 10, м. Київ, 04070, Україна', 'вул. Хрещатик, 22, м. Київ, 01001, Україна', '2024-05-29 03:23:32', '2024-05-29 03:23:32');
