CREATE TABLE `df_tg_messages` (
  `tgm_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tgm_chat_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'id TG пользователя',
  `tgm_msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgm_add_date` datetime NOT NULL,
  PRIMARY KEY (`tgm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Отправленные в Telegram сообщения';

INSERT INTO `df_tg_messages` VALUES ('1', '794375162', 'Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/df/messages)', '2024-06-02 11:26:07');
INSERT INTO `df_tg_messages` VALUES ('2', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/df/messages)', '2024-06-02 11:27:58');
INSERT INTO `df_tg_messages` VALUES ('3', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/df/messages)', '2024-06-02 11:46:27');
INSERT INTO `df_tg_messages` VALUES ('4', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/df/messages)', '2024-06-02 11:47:56');
INSERT INTO `df_tg_messages` VALUES ('5', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/df/messages)', '2024-06-02 11:48:10');
INSERT INTO `df_tg_messages` VALUES ('6', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/df/messages)', '2024-06-02 15:11:25');
INSERT INTO `df_tg_messages` VALUES ('7', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/df/messages)', '2024-06-02 15:19:15');
INSERT INTO `df_tg_messages` VALUES ('8', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-02 15:20:15');
INSERT INTO `df_tg_messages` VALUES ('9', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-02 15:30:07');
INSERT INTO `df_tg_messages` VALUES ('10', '794375162', 'Test', '2024-06-02 15:38:32');
INSERT INTO `df_tg_messages` VALUES ('11', '794375162', 'Test', '2024-06-02 15:40:03');
INSERT INTO `df_tg_messages` VALUES ('12', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-02 16:17:47');
INSERT INTO `df_tg_messages` VALUES ('13', '602635770', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-02 16:17:47');
INSERT INTO `df_tg_messages` VALUES ('14', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-02 16:18:54');
INSERT INTO `df_tg_messages` VALUES ('15', '602635770', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-02 16:18:54');
INSERT INTO `df_tg_messages` VALUES ('16', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-02 16:25:13');
INSERT INTO `df_tg_messages` VALUES ('17', '794375162', '❇️ Ви маєте 2 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-03 11:22:45');
INSERT INTO `df_tg_messages` VALUES ('18', '602635770', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-03 11:22:45');
INSERT INTO `df_tg_messages` VALUES ('19', '794375162', '❇️ Ви маєте 2 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-03 11:22:46');
INSERT INTO `df_tg_messages` VALUES ('20', '602635770', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-03 11:22:46');
INSERT INTO `df_tg_messages` VALUES ('21', '794375162', '❇ Сьогодні контрольна дата [документа](http://document-flow.loc/df/documents-incoming/card?n=00000001).', '2024-06-03 22:05:31');
INSERT INTO `df_tg_messages` VALUES ('22', '794375162', '❇ Сьогодні контрольна дата [документа](http://document-flow.loc/df/documents-incoming/card?n=00000001).', '2024-06-03 22:07:50');
INSERT INTO `df_tg_messages` VALUES ('23', '794375162', '❇ Сьогодні контрольна дата документа [INC_00000001](http://document-flow.loc/df/documents-incoming/card?n=00000001).', '2024-06-03 22:10:36');
INSERT INTO `df_tg_messages` VALUES ('24', '794375162', '❇ Сьогодні контрольна дата документа [INC_00000001](http://document-flow.loc/df/documents-incoming/card?n=00000001).', '2024-06-03 23:40:16');
INSERT INTO `df_tg_messages` VALUES ('25', '794375162', '/var/www/html/document-flow.loc/public/cron/main.php', '2024-06-04 11:56:15');
INSERT INTO `df_tg_messages` VALUES ('26', '794375162', '/var/www/html/document-flow.loc/public/cron/main.php', '2024-06-04 11:57:56');
INSERT INTO `df_tg_messages` VALUES ('27', '794375162', '/var/www/html/document-flow.loc/public/cron/main.php', '2024-06-04 11:58:43');
INSERT INTO `df_tg_messages` VALUES ('28', '794375162', '/var/www/html/document-flow.loc/index.php: 28', '2024-06-05 14:07:04');
INSERT INTO `df_tg_messages` VALUES ('29', '794375162', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '2024-06-05 14:07:53');
INSERT INTO `df_tg_messages` VALUES ('30', '794375162', '❇️ Ви маєте 7 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-06 13:31:53');
INSERT INTO `df_tg_messages` VALUES ('31', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-09 08:41:40');
INSERT INTO `df_tg_messages` VALUES ('32', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-09 11:10:29');
INSERT INTO `df_tg_messages` VALUES ('33', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-09 11:10:55');
INSERT INTO `df_tg_messages` VALUES ('34', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-09 11:12:08');
INSERT INTO `df_tg_messages` VALUES ('35', '794375162', '❇️ Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-09 11:16:44');
INSERT INTO `df_tg_messages` VALUES ('36', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `10.06.2024 06:17:55`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-10 06:17:56');
INSERT INTO `df_tg_messages` VALUES ('37', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `10.06.2024 06:46:37`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-10 06:46:38');
INSERT INTO `df_tg_messages` VALUES ('38', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `10.06.2024 06:53:34`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-10 06:53:35');
INSERT INTO `df_tg_messages` VALUES ('39', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `10.06.2024 06:55:31`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-10 06:55:31');
INSERT INTO `df_tg_messages` VALUES ('40', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `10.06.2024 06:57:15`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-10 06:57:16');
INSERT INTO `df_tg_messages` VALUES ('41', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `10.06.2024 07:00:25`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-10 07:00:26');
INSERT INTO `df_tg_messages` VALUES ('42', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `10.06.2024 07:02:07`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-10 07:02:07');
INSERT INTO `df_tg_messages` VALUES ('43', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `10.06.2024 07:06:53`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-10 07:06:53');
INSERT INTO `df_tg_messages` VALUES ('44', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `10.06.2024 07:07:15`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-10 07:07:16');
INSERT INTO `df_tg_messages` VALUES ('45', '794375162', '‼️ Увага! Незвичайний відвідувач `Admin`.\n\nIP: `127.0.0.1`\nUser agent: `Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36`', '2024-06-12 19:32:48');
INSERT INTO `df_tg_messages` VALUES ('46', '794375162', '‼️ Увага! Незвичайний відвідувач `Admin`.\n\nIP: `127.0.0.1`\nUser agent: `Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36`\nЧас відвідування: `12.06.2024 19:36:50`', '2024-06-12 19:36:50');
INSERT INTO `df_tg_messages` VALUES ('47', '794375162', '‼️ Увага! Незвичайний відвідувач `Admin`.\n\nIP: `127.0.0.1`\nUser agent: `Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36`\nЧас відвідування: `12.06.2024 19:38:28`', '2024-06-12 19:38:28');
INSERT INTO `df_tg_messages` VALUES ('48', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `13.06.2024 18:36:58`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-13 18:36:59');
INSERT INTO `df_tg_messages` VALUES ('49', '794375162', '❇️ Cron завдання: створено повний бекап бази даних. Час створення: `13.06.2024 18:37:42`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-13 18:37:42');
INSERT INTO `df_tg_messages` VALUES ('50', '794375162', '⏰ Cron завдання: створено повний бекап бази даних. Час створення: `14.06.2024 18:48:19`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-14 18:48:19');
INSERT INTO `df_tg_messages` VALUES ('51', '794375162', '⏰ *Cron завдання*\n\nСтворено повний бекап бази даних. Час створення: `14.06.2024 18:49:53`.\n\nЛист з архівом БД відправлено на email: vladimirovichser@gmail.com.', '2024-06-14 18:49:53');
INSERT INTO `df_tg_messages` VALUES ('52', '794375162', '‼️ *Увага - виключення*\n\n/var/www/html/document-flow.loc/core/controllers/CronController.php, line: 31\n\n\\n\\n📍 *Прикріплені дані*\n\ncronFile: /var/www/html/document-flow.loc/modules/df/controllerss/CronController.php\n\n⏰ виключення: 18.06.2024 11:53:00', '2024-06-18 11:53:00');
INSERT INTO `df_tg_messages` VALUES ('53', '794375162', '‼️ *Увага - виключення*\n\n/var/www/html/document-flow.loc/core/controllers/CronController.php, line: 31\n\n📍 *Прикріплені дані*\n\ncronFile: /var/www/html/document-flow.loc/modules/df/controllerss/CronController.php\n\n⏰ виключення: 18.06.2024 11:53:31', '2024-06-18 11:53:31');
INSERT INTO `df_tg_messages` VALUES ('54', '794375162', '‼️ *Увага - виключення*\n\nSource: /var/www/html/document-flow.loc/core/controllers/CronController.php, line: 31\n\n📍 *Прикріплені дані*\n\n*cronFile:* /var/www/html/document-flow.loc/modules/df/controllerss/CronController.php\n\n⏰ події: 18.06.2024 11:56:22', '2024-06-18 11:56:22');
INSERT INTO `df_tg_messages` VALUES ('55', '794375162', '‼️ *Увага - виключення*\n\nSource: /var/www/html/document-flow.loc/core/controllers/CronController.php, line: 31\n\n📍 *Прикріплені дані*\n\n*cronFile:* /var/www/html/document-flow.loc/modules/df/controllerss/CronController.php\n\n⏰ події: `18.06.2024 11:56:53`', '2024-06-18 11:56:53');
INSERT INTO `df_tg_messages` VALUES ('56', '794375162', '‼️ *Увага - виключення*\n\nSource: /var/www/html/document-flow.loc/core/controllers/CronController.php, line: 31\n\n📍 *Прикріплені дані*\n\n*cronFile:* /var/www/html/document-flow.loc/modules/df/controllerss/CronController.php\n\n⏰ події: `18.06.2024 12:00:12`', '2024-06-18 12:00:12');
INSERT INTO `df_tg_messages` VALUES ('57', '794375162', '‼️ *Увага - виключення*\n\nSource: /var/www/html/document-flow.loc/core/controllers/CronController.php, line: 31\n\n📍 *Прикріплені дані*\n\n*cronFile:* /var/www/html/document-flow.loc/modules/df/controllerss/CronController.php\n\n⏰ події: `18.06.2024 12:02:40`', '2024-06-18 12:02:40');
INSERT INTO `df_tg_messages` VALUES ('58', '602635770', '‼️ *Увага - виключення*\n\nSource: /var/www/html/document-flow.loc/core/controllers/CronController.php, line: 31\n\n📍 *Прикріплені дані*\n\n*cronFile:* /var/www/html/document-flow.loc/modules/df/controllerss/CronController.php\n\n⏰ події: `18.06.2024 12:02:40`', '2024-06-18 12:02:41');
INSERT INTO `df_tg_messages` VALUES ('59', '794375162', '‼️ *Увага - виключення*\n\n*Source:* /var/www/html/document-flow.loc/core/controllers/CronController.php, line: 31\n\n📍 *Прикріплені дані*\n\n*cronFile:* /var/www/html/document-flow.loc/modules/df/controllerss/CronController.php\n\n⏰ події: `18.06.2024 12:03:50`', '2024-06-18 12:03:50');
INSERT INTO `df_tg_messages` VALUES ('60', '602635770', '‼️ *Увага - виключення*\n\n*Source:* /var/www/html/document-flow.loc/core/controllers/CronController.php, line: 31\n\n📍 *Прикріплені дані*\n\n*cronFile:* /var/www/html/document-flow.loc/modules/df/controllerss/CronController.php\n\n⏰ події: `18.06.2024 12:03:50`', '2024-06-18 12:03:51');
INSERT INTO `df_tg_messages` VALUES ('61', '794375162', '📌 Ви маєте 1 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-18 12:17:16');
INSERT INTO `df_tg_messages` VALUES ('62', '602635770', '📌 Ви маєте 4 непрочитаних [повідомлень](http://document-flow.loc/messages)', '2024-06-18 12:17:16');
