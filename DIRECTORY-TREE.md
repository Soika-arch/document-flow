.
├── configs
│   ├── db.php
│   ├── main.php
│   ├── regexp.php
│   └── secrets.php
├── core
│   ├── controllers
│   │   ├── CronController.php
│   │   ├── MainController.php
│   │   ├── MessagesController.php
│   │   └── UserController.php
│   ├── Db.php
│   ├── db_record
│   │   ├── cron_tasks.php
│   │   ├── DbRecord.php
│   │   ├── departments.php
│   │   ├── DfDocument.php
│   │   ├── document_carrier_types.php
│   │   ├── document_control_types.php
│   │   ├── document_descriptions.php
│   │   ├── document_resolutions.php
│   │   ├── document_senders.php
│   │   ├── document_titles.php
│   │   ├── document_types.php
│   │   ├── incoming_documents_registry.php
│   │   ├── internal_documents_registry.php
│   │   ├── outgoing_documents_registry.php
│   │   ├── tg_messages.php
│   │   ├── user_messages.php
│   │   ├── users.php
│   │   ├── users_rel_statuses.php
│   │   ├── user_statuses.php
│   │   └── visitor_routes.php
│   ├── Debug.php
│   ├── exceptions
│   │   ├── ClassException.php
│   │   ├── DbException.php
│   │   ├── DbRecordException.php
│   │   ├── MainException.php
│   │   ├── ModuleException.php
│   │   ├── RouterException.php
│   │   └── SingletonException.php
│   ├── Get.php
│   ├── Header.php
│   ├── models
│   │   ├── CronModel.php
│   │   ├── MainModel.php
│   │   ├── MessagesModel.php
│   │   └── UserModel.php
│   ├── Post.php
│   ├── RecordSliceRetriever.php
│   ├── Registry.php
│   ├── Router.php
│   ├── traits
│   │   ├── SetGet.php
│   │   ├── Singleton.php
│   │   └── Singleton_SetGet.php
│   ├── User.php
│   ├── UserRelStatus.php
│   └── views
│       ├── confirmation.php
│       ├── inc
│       │   ├── errors.php
│       │   ├── footer_debug_info.php
│       │   ├── footer.php
│       │   ├── header.php
│       │   ├── menu
│       │   │   ├── main.php
│       │   │   └── user_1.php
│       │   └── sys_messages.php
│       ├── main.php
│       ├── messages
│       │   ├── main.php
│       │   └── viewing.php
│       ├── page_not_found.php
│       └── user
│           ├── main.php
│           └── profile.php
├── db_backup
├── functions
│   ├── cron.php
│   ├── db.php
│   ├── hd.php
│   ├── main.php
│   ├── msg.php
│   ├── rg.php
│   ├── rt.php
│   ├── sess.php
│   ├── tg.php
│   ├── tm.php
│   └── users.php
├── index.php
├── libs
│   ├── cron
│   │   ├── AbstractField.php
│   │   ├── CronExpression.php
│   │   ├── DayOfMonthField.php
│   │   ├── DayOfWeekField.php
│   │   ├── FieldFactory.php
│   │   ├── FieldInterface.php
│   │   ├── HoursField.php
│   │   ├── MinutesField.php
│   │   └── MonthField.php
│   ├── Paginator.php
│   └── query_builder
│       ├── Condition.php
│       ├── Connection.php
│       ├── DatabaseException.php
│       ├── DeleteQuery.php
│       ├── FunctionBuilder.php
│       ├── FunctionExpression.php
│       ├── InsertQuery.php
│       ├── Operator.php
│       ├── QueryInterface.php
│       ├── Quoter.php
│       ├── RawExp.php
│       ├── SelectQueryBuilder.php
│       ├── SelectQuery.php
│       └── UpdateQuery.php
├── modules
│   ├── ap
│   │   ├── ap.php
│   │   ├── configs
│   │   │   └── main.php
│   │   ├── controllers
│   │   │   ├── MainController.php
│   │   │   ├── SecurityController.php
│   │   │   └── UsersController.php
│   │   ├── db_record
│   │   ├── functions
│   │   ├── models
│   │   │   ├── MainModel.php
│   │   │   ├── SecurityModel.php
│   │   │   └── UsersModel.php
│   │   └── views
│   │       ├── inc
│   │       │   └── menu
│   │       │       ├── main.php
│   │       │       └── users_1.php
│   │       ├── main.php
│   │       ├── security
│   │       │   ├── main.php
│   │       │   └── visits_list.php
│   │       └── users
│   │           ├── add.php
│   │           ├── edit.php
│   │           ├── list.php
│   │           └── main.php
│   └── df
│       ├── controllers
│       │   ├── CronController.php
│       │   ├── DocumentRegistrationController.php
│       │   ├── DocumentsIncomingController.php
│       │   ├── DocumentsInternalController.php
│       │   ├── DocumentsOutgoingController.php
│       │   ├── DocumentTypesController.php
│       │   ├── MainController.php
│       │   ├── ReportsController.php
│       │   └── SearchController.php
│       ├── df.php
│       ├── functions
│       │   └── df.php
│       ├── models
│       │   ├── CronModel.php
│       │   ├── DocumentRegistrationModel.php
│       │   ├── DocumentsIncomingModel.php
│       │   ├── DocumentsInternalModel.php
│       │   ├── DocumentsOutgoingModel.php
│       │   ├── DocumentTypesModel.php
│       │   ├── MainModel.php
│       │   ├── ReportsModel.php
│       │   └── SearchModel.php
│       ├── storage
│       │   ├── INC_00000001.png
│       │   ├── INC_00000002.torrent
│       │   ├── INC_00000003.jpg
│       │   ├── INC_00000004.png
│       │   ├── INC_00000005.png
│       │   ├── INC_00000006.png
│       │   ├── INC_00000007.docx
│       │   ├── INC_00000008.sql
│       │   ├── INC_00000009.png
│       │   ├── INC_00000010.png
│       │   ├── INC_00000011.png
│       │   ├── INT_00000001.png
│       │   ├── INT_00000002.png
│       │   ├── OUT_00000002.png
│       │   └── OUT_00000012.png
│       └── views
│           ├── document_registration
│           │   ├── incoming.php
│           │   ├── internal.php
│           │   ├── outgoing.php
│           │   └── type_selection.php
│           ├── documents_incoming
│           │   ├── card.php
│           │   ├── list.php
│           │   └── main.php
│           ├── documents_internal
│           │   ├── card.php
│           │   └── list.php
│           ├── documents_outgoing
│           │   ├── card.php
│           │   └── list.php
│           ├── document_types
│           │   ├── add.php
│           │   ├── list.php
│           │   └── main.php
│           ├── inc
│           │   └── menu
│           │       ├── dt_menu.php
│           │       ├── main.php
│           │       └── menu_journal_1.php
│           ├── main.php
│           ├── print_card.php
│           ├── reports
│           │   ├── main.php
│           │   ├── r0001.php
│           │   ├── r0002.php
│           │   ├── r0003.php
│           │   ├── r0004.php
│           │   ├── r0005.php
│           │   ├── r0006.php
│           │   ├── r0007.php
│           │   └── r0008.php
│           └── search
│               └── main.php
├── public
│   ├── css
│   │   ├── ap.css
│   │   ├── df.css
│   │   ├── main.css
│   │   └── print_card.css
│   ├── favicon.ico
│   ├── img
│   │   ├── clear.png
│   │   ├── delete.png
│   │   ├── email1.jpg
│   │   ├── email2.jpg
│   │   └── print.png
│   ├── index.php
│   └── js
│       ├── df.js
│       ├── df_reports.js
│       ├── df_search.js
│       └── main.js

54 directories, 250 files
