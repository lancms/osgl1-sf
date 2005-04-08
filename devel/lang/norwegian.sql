-- MySQL dump 9.11
--
-- Host: localhost    Database: GlobeLAN8
-- ------------------------------------------------------
-- Server version	4.0.23_Debian-4-log

--
-- Table structure for table `lang`
--

CREATE TABLE lang (
  ID int(11) NOT NULL auto_increment,
  string text,
  language varchar(30) NOT NULL default 'english',
  module varchar(30) default NULL,
  translated text,
  extra text,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `lang`
--

INSERT INTO lang VALUES (58,'Back to main page','english','seat',NULL,'Link to get back to main page in seat.php');
INSERT INTO lang VALUES (59,'PartyAdmin','english','admin_index',NULL,'Menuitem in admin.php to view PartyAdmin-interface');
INSERT INTO lang VALUES (60,'FAQadmin','english','admin_index',NULL,'Menuitem in admin.php to view FAQadmin-interface');
INSERT INTO lang VALUES (61,'StaticAdmin','english','admin_index',NULL,'Menuitem in admin.php to view static files');
INSERT INTO lang VALUES (62,'Users','english','admin_index',NULL,'Menuitem in admin.php to edit users');
INSERT INTO lang VALUES (63,'Online Users','english','admin_index',NULL,'Menuitem in admin.php to list users currently online');
INSERT INTO lang VALUES (64,'Polls','english','admin_index',NULL,'Menuitem in admin.php to view and edit polls');
INSERT INTO lang VALUES (65,'News','english','admin_index',NULL,'Menuitem in admin.php to view/edit/add news');
INSERT INTO lang VALUES (66,'Accessmanagement','english','admin_index',NULL,'Menuitem on admin.php to manipulate groups and ACL-rights');
INSERT INTO lang VALUES (67,'CompoMaster','english','admin_index',NULL,'Menuitem in admin.php to manipulate compos');
INSERT INTO lang VALUES (68,'Compopolladmin','english','admin_index',NULL,'Menuitem in admin.php to view/edit/add compopolls');
INSERT INTO lang VALUES (69,'ID','english','addressbook',NULL,'UserID-column in SELECT in addressbook');
INSERT INTO lang VALUES (70,'nick','english','addressbook',NULL,'nick-column in SELECT in addressbook');
INSERT INTO lang VALUES (71,'Groupname','english','addressbook',NULL,'Groupname-column in SELECT in addressbook');
INSERT INTO lang VALUES (72,'EMail','english','addressbook',NULL,'EMail-column in SELECT in addressbook');
INSERT INTO lang VALUES (73,'Phonenumber','english','addressbook',NULL,'Phonenumber-column in SELECT in addressbook');
INSERT INTO lang VALUES (74,'Resend validation EMail','english','root_do',NULL,'Linktext to resend validation EMail');
INSERT INTO lang VALUES (75,'System Configurations','english','admin_index',NULL,'Menuitem in admin.php to change config');
INSERT INTO lang VALUES (76,'Taskmanager','english','admin_index',NULL,'Menuitem in admin.php to list and add tasks');
INSERT INTO lang VALUES (77,'Firstname','english','inc_register',NULL,'Register: Firstname');
INSERT INTO lang VALUES (78,'Lastname','english','inc_register',NULL,'Register: Lastname');
INSERT INTO lang VALUES (79,'Firstname','english','inc_useradmin',NULL,'Users firstname in useradmin?action=view');
INSERT INTO lang VALUES (80,'Lastname','english','inc_useradmin',NULL,'Users lastname in useradmin?action=view');
INSERT INTO lang VALUES (81,'Task name','english','admin_tasks',NULL,'Form-field Task Name');
INSERT INTO lang VALUES (82,'Add task','english','admin_tasks',NULL,'Form submit: add task');
INSERT INTO lang VALUES (83,'usepage_faq','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (84,'usepage_register','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (85,'usepage_poll','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (86,'usepage_static','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (87,'usepage_profile','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (88,'usepage_seat','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (89,'usepage_compo','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (90,'usepage_news','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (91,'usepage_partyweb','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (92,'seatreg_open','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (93,'usepage_wannabe','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (94,'usepage_compopoll','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (95,'disable_userstyle','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (1,'Firstname','norwegian','inc_useradmin','Fornavn','Users firstname in useradmin?action=view');
INSERT INTO lang VALUES (2,'Lastname','norwegian','inc_useradmin','Etternavn','Users lastname in useradmin?action=view');
INSERT INTO lang VALUES (3,'PartyAdmin','norwegian','admin_index','PartyAdmin','Menuitem in admin.php to view PartyAdmin-interface');
INSERT INTO lang VALUES (4,'FAQadmin','norwegian','admin_index','FAQadmin','Menuitem in admin.php to view FAQadmin-interface');
INSERT INTO lang VALUES (5,'StaticAdmin','norwegian','admin_index','Rediger statiske sider','Menuitem in admin.php to view static files');
INSERT INTO lang VALUES (6,'Users','norwegian','admin_index','Rediger brukere','Menuitem in admin.php to edit users');
INSERT INTO lang VALUES (7,'Online Users','norwegian','admin_index','Brukere online','Menuitem in admin.php to list users currently online');
INSERT INTO lang VALUES (8,'Polls','norwegian','admin_index','Avstemninger','Menuitem in admin.php to view and edit polls');
INSERT INTO lang VALUES (9,'News','norwegian','admin_index','Nyheter','Menuitem in admin.php to view/edit/add news');
INSERT INTO lang VALUES (10,'Accessmanagement','norwegian','admin_index','Tilgangskontroll','Menuitem on admin.php to manipulate groups and ACL-rights');
INSERT INTO lang VALUES (11,'CompoMaster','norwegian','admin_index','CompoMaster','Menuitem in admin.php to manipulate compos');
INSERT INTO lang VALUES (12,'Compopolladmin','norwegian','admin_index','Compoavstemning','Menuitem in admin.php to view/edit/add compopolls');
INSERT INTO lang VALUES (13,'System Configurations','norwegian','admin_index','Konfigurasjon','Menuitem in admin.php to change config');
INSERT INTO lang VALUES (14,'Taskmanager','norwegian','admin_index','Oppgaveplanlegger','Menuitem in admin.php to list and add tasks');
INSERT INTO lang VALUES (15,'usepage_faq','norwegian','admin_config','Bruk modul: FAQ','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (16,'usepage_register','norwegian','admin_config','Bruk modul: Brukerregistrering','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (17,'usepage_poll','norwegian','admin_config','Bruk modul: Avstemninger','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (18,'usepage_static','norwegian','admin_config','Bruk modul: Statiske websider','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (19,'usepage_profile','norwegian','admin_config','Bruk modul: Brukerprofiler','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (20,'usepage_seat','norwegian','admin_config','Bruk modul: Plassregistrering','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (21,'usepage_compo','norwegian','admin_config','Bruk modul: Composystem','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (22,'usepage_news','norwegian','admin_config','Bruk modul: Nyheter','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (23,'usepage_partyweb','norwegian','admin_config','Bruk modul: PartyWeb','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (24,'seatreg_open','norwegian','admin_config','Plassregistreringa er åpnet for deltagere','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (25,'usepage_wannabe','norwegian','admin_config','Bruk modul: Wannabe','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (26,'usepage_compopoll','norwegian','admin_config','Bruk modul: Compoavstemning','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (27,'disable_userstyle','norwegian','admin_config','Fjern brukerens mulighet til å endre theme på siden','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (28,'ID','norwegian','addressbook','BrukerID','UserID-column in SELECT in addressbook');
INSERT INTO lang VALUES (29,'nick','norwegian','addressbook','Kallenavn','nick-column in SELECT in addressbook');
INSERT INTO lang VALUES (30,'Groupname','norwegian','addressbook','Gruppenavn','Groupname-column in SELECT in addressbook');
INSERT INTO lang VALUES (31,'EMail','norwegian','addressbook','E-Post','EMail-column in SELECT in addressbook');
INSERT INTO lang VALUES (32,'Phonenumber','norwegian','addressbook','Telefonnummer','Phonenumber-column in SELECT in addressbook');
INSERT INTO lang VALUES (33,'Delete this page!','norwegian','admin_static','Slett siden','Admin->static->edit->Delete this page');
INSERT INTO lang VALUES (34,'Updated page. Saving to database, stand by','norwegian','admin_static','Siden oppdatert. Lagrer til databasen, venligst vent','Text to display when a static file is saved');
INSERT INTO lang VALUES (35,'Firstname','norwegian','inc_register','Fornavn','Register: Firstname');
INSERT INTO lang VALUES (36,'Lastname','norwegian','inc_register','Etternavn','Register: Lastname');
INSERT INTO lang VALUES (37,'Resend validation EMail','norwegian','root_do','Send valideringskoden til meg på nytt','Linktext to resend validation EMail');
INSERT INTO lang VALUES (38,'User already verified.','norwegian','root_do','Brukeren er allerede verifisert!','Text to display to already verified users');
INSERT INTO lang VALUES (39,'Task name','norwegian','admin_tasks','Oppgavenavn','Form-field Task Name');
INSERT INTO lang VALUES (40,'Add task','norwegian','admin_tasks','Legg til oppgave','Form submit: add task');
INSERT INTO lang VALUES (41,'Task added, returning to task index','norwegian','admin_tasks','Oppgave lagt til, går tilbake til oppgaveoversikten','Task added, returning to index of tasks');
INSERT INTO lang VALUES (42,'Task','norwegian','admin_tasks','Oppgave','Table header, Task name');
INSERT INTO lang VALUES (43,'Assigned to','norwegian','admin_tasks','Tildelt','Table header, Task Assigned to');
INSERT INTO lang VALUES (44,'Completed %','norwegian','admin_tasks','Fullført %','Table header, Task Completed %');
INSERT INTO lang VALUES (45,'Task name: ','norwegian','admin_tasks','Oppgavenavn: ','Task name in edit');
INSERT INTO lang VALUES (46,'Assigned to: ','norwegian','admin_tasks','Tildelt: ','Assigned to on edit');
INSERT INTO lang VALUES (47,'Change assigned user','norwegian','admin_tasks','Endre tildelt bruker','form-submit to change user in tasks');
INSERT INTO lang VALUES (48,'Change completeness','norwegian','admin_tasks','Endre fullførthet','form-submit to change completeness');
INSERT INTO lang VALUES (49,'Add comment','norwegian','admin_tasks','Legg til kommentar','Submit-button to add comment on a task');
INSERT INTO lang VALUES (50,'Changed assigned to user to: ','norwegian','admin_tasks','Endret tildelt bruker til: ','What to put into the SQL-table when a user changes who a task is assigned to');
INSERT INTO lang VALUES (51,'Changed assigned user successfully','norwegian','admin_tasks','Endret tildelt bruker OK','What to display after we have changed the user a task is assigned to');
INSERT INTO lang VALUES (52,'Comment added','norwegian','admin_tasks','Kommentar lagt til','Text to display after a comment has been added.');
INSERT INTO lang VALUES (56,'No seat','norwegian','inc_userlogin','Ingen plass','Text to display if the user does not have any seat');
INSERT INTO lang VALUES (57,'Back to main page','norwegian','seat','Tilbake til hovedsiden','Link to get back to main page in seat.php');
INSERT INTO lang VALUES (96,'No seat','english','inc_userlogin',NULL,'Text to display if the user does not have any seat');
INSERT INTO lang VALUES (97,'Yes, I want to be a crew member!','english','inc_wannabe',NULL,'Text used in wannabe');
INSERT INTO lang VALUES (98,'Continue','english','inc_wannabe',NULL,'Text used in wannabe');
INSERT INTO lang VALUES (99,'Add question','english','admin_wannabemin',NULL,'Text to display in wannabe admin menu');
INSERT INTO lang VALUES (100,'View Users','english','admin_wannabemin',NULL,'Text to display in wannabe admin menu');
INSERT INTO lang VALUES (101,'Questions:','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (102,'Add new question','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (103,'Question:','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (104,'Type:','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (105,'Text','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (106,'Alternatives','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (107,'Add','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (108,'Wannabe','english','inc_wannabe',NULL,'Text to display in wannabe');
INSERT INTO lang VALUES (109,'Save','english','inc_wannabe',NULL,'Text to display in wannabe');
INSERT INTO lang VALUES (110,'Updated !','english','inc_wannabe',NULL,'Text to display in wannabe');
INSERT INTO lang VALUES (111,'You must check the checkbox','english','inc_wannabe',NULL,'Text used in wannabe');
INSERT INTO lang VALUES (112,'Nope, this is not the way you shoul do it... Try writing somthing in the fields next time :)','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (113,'Time to add som alternatives.','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (114,'New Alternative:','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (115,'Save','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (116,'Alternative:','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (117,'Delete','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (118,'Question has been added','english','admin_wannabemin',NULL,'Text used in wannabemin');
INSERT INTO lang VALUES (119,'usepage_show_stats','english','admin_config',NULL,'checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (120,'Statistics','english','style_menu',NULL,'Menuitem for stats');
INSERT INTO lang VALUES (121,'OSes that have visited this page:','english','inc_stats',NULL,'Text to display as a header for OSes that have visited the site');
INSERT INTO lang VALUES (122,'Operating System: ','english','inc_stats',NULL,'Table header for OS');
INSERT INTO lang VALUES (123,'Number of hits','english','inc_stats',NULL,'Text to display as header for OS hits');
INSERT INTO lang VALUES (124,'Percentage of hits','english','inc_stats',NULL,'Text to display as header for OS hitpercentage');
INSERT INTO lang VALUES (125,'Other','english','inc_stats',NULL,'Text to display if it is another OS than one specifically mentioned');
INSERT INTO lang VALUES (126,'Nobody here','english','admin_wannabemin',NULL,'Text to display in wannabemin&action=ViewUsers');
INSERT INTO lang VALUES (127,'You have to be logged in to view this page!','english','inc_clan',NULL,'Error-msg to display in inc/clan if you are not logged in');
INSERT INTO lang VALUES (128,'Yes, I want to be a crew member.','english','inc_wannabe',NULL,'Text to display in wannabe');
INSERT INTO lang VALUES (129,'Save','english','admin_config',NULL,'form[15]');
INSERT INTO lang VALUES (130,'Wrong username or password.','english','root_do',NULL,'Wrong username or password-warning');
INSERT INTO lang VALUES (131,'Main Page','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (132,'News','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (133,'FAQ','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (134,'Register','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (135,'Polls','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (136,'Seatmap','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (137,'Composystem','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (138,'Partyweb','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (139,'Edit profile','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (140,'Clanregistration','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (141,'Compopoll','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (142,'WannabeCrew','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (143,'Userlogin','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (144,'Crewaddressbook','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (145,'ADMIN','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (146,'Logout','english','style_menu',NULL,'menuitem in write_menu');
INSERT INTO lang VALUES (147,'Menuname','english','admin_partyweb',NULL,'partyweb[0]');
INSERT INTO lang VALUES (148,'Display in menu','english','admin_partyweb',NULL,'partyweb[1]');
INSERT INTO lang VALUES (149,'Display in partymode','english','admin_partyweb',NULL,'partyweb[2]');
INSERT INTO lang VALUES (150,'Save','english','admin_partyweb',NULL,'form[15]');
INSERT INTO lang VALUES (151,'Delete page','english','admin_partyweb',NULL,'partyweb[3]');
INSERT INTO lang VALUES (152,'Update complete.','english','admin_partyweb',NULL,'partyweb[4]');
INSERT INTO lang VALUES (153,'Seats, total:','norwegian','seat','Plasser, totalt:','');
INSERT INTO lang VALUES (154,'Seats, taken:','norwegian','seat','Plasser, okkupert:','');
INSERT INTO lang VALUES (155,'Seats, free:','norwegian','seat','Plasser, ledig:','');
INSERT INTO lang VALUES (156,'Main Page','norwegian','style_menu','Hovedsiden','menuitem in write_menu');
INSERT INTO lang VALUES (157,'News','norwegian','style_menu','Nyheter','menuitem in write_menu');
INSERT INTO lang VALUES (158,'Register','norwegian','style_menu','Registrer bruker','menuitem in write_menu');
INSERT INTO lang VALUES (159,'Seatmap','norwegian','style_menu','Plassregistrering','menuitem in write_menu');
INSERT INTO lang VALUES (160,'Forum','norwegian','style_menu','Forum','menuitem in write_menu');
INSERT INTO lang VALUES (161,'Statistics','norwegian','style_menu','Statestikk','Menuitem for stats');
INSERT INTO lang VALUES (162,'Edit profile','norwegian','style_menu','Rediger profil','menuitem in write_menu');
INSERT INTO lang VALUES (163,'Userlogin','norwegian','style_menu','Brukerinnlogging','menuitem in write_menu');
INSERT INTO lang VALUES (164,'Crewaddressbook','norwegian','style_menu','Crewaddressebok','menuitem in write_menu');
INSERT INTO lang VALUES (165,'ADMIN','norwegian','style_menu','ADMIN','menuitem in write_menu');
INSERT INTO lang VALUES (166,'Logout','norwegian','style_menu','Logg ut','menuitem in write_menu');
INSERT INTO lang VALUES (167,'OSes that have visited this page:','norwegian','inc_stats','OS som har besøkt denne siden:','Text to display as a header for OSes that have visited the site');
INSERT INTO lang VALUES (168,'Operating System: ','norwegian','inc_stats','OS','Table header for OS');
INSERT INTO lang VALUES (169,'Number of hits','norwegian','inc_stats','Antall treff','Text to display as header for OS hits');
INSERT INTO lang VALUES (170,'Percentage of hits','norwegian','inc_stats','Andel av treff','Text to display as header for OS hitpercentage');
INSERT INTO lang VALUES (171,'Other','norwegian','inc_stats','Andre','Text to display if it is another OS than one specifically mentioned');
INSERT INTO lang VALUES (172,'Wrong username or password.','norwegian','root_do','Feil brukernavn eller passord','Wrong username or password-warning');
INSERT INTO lang VALUES (173,'Close','norwegian','admin_compomaster','Avslutt','form[23]');
INSERT INTO lang VALUES (174,'Seeding','norwegian','admin_compomaster','Seeding','compo[18]');
INSERT INTO lang VALUES (175,'Signed up:','norwegian','admin_compomaster','Påmeldte:','compo[19]');
INSERT INTO lang VALUES (176,'users','norwegian','admin_compomaster','brukere','compo[20]');
INSERT INTO lang VALUES (177,'distributed on','norwegian','admin_compomaster','fordelt på','compo[21]');
INSERT INTO lang VALUES (178,'clans','norwegian','admin_compomaster','klaner','compo[22]');
INSERT INTO lang VALUES (179,'Name of the compo','norwegian','admin_compomaster','Navn på compo','form[68]');
INSERT INTO lang VALUES (180,'Add','norwegian','admin_compomaster','Legg til','form[7]');
INSERT INTO lang VALUES (181,'Back to the list.','norwegian','admin_compomaster','Tilbake til lista','msg[32]');
INSERT INTO lang VALUES (182,'Number of teams in each round','norwegian','admin_compomaster','Antall lag i hver runde','form[71]');
INSERT INTO lang VALUES (183,'Save','norwegian','admin_compomaster','Lagre','form[15]');
INSERT INTO lang VALUES (184,'usepage_show_stats','norwegian','admin_config','Bruk modul: Statestikk','checkbox-item in admin/config.php, as they are displayed on the page');
INSERT INTO lang VALUES (185,'Save','norwegian','admin_config','Lagre','form[15]');
INSERT INTO lang VALUES (186,'You are now logged out.','norwegian','root_do','Du er nå logget ut','Logout-message');
INSERT INTO lang VALUES (187,'Please enter the verificationcode that was sent to your emailaddress.','norwegian','root_do','Venligst skriv inn verifiseringskoden som ble sendt til din e-post-adresse','');
INSERT INTO lang VALUES (188,'If you have not recieved your verificationcode within a reasonable time, please contact the administrators.','norwegian','root_do','Hvis du ikke har mottatt verifiseringskoden din innen en fornuftig tid, kontakt administratorene','Explains what to do if youve not recieved your verificationcode');
INSERT INTO lang VALUES (189,'Verify','norwegian','root_do','Verifiser','Verify-button-text');
INSERT INTO lang VALUES (190,'You have been verified.','norwegian','root_do','Du har blitt verifisert','Text to show when verified');
INSERT INTO lang VALUES (191,'Rename','norwegian','admin_acl','Gi nytt navn','form[62]');
INSERT INTO lang VALUES (192,'Delete','norwegian','admin_acl','Slett','form[16]');
INSERT INTO lang VALUES (193,'Add group','norwegian','admin_acl','Legg til gruppe','form[61]');
INSERT INTO lang VALUES (194,'Save','norwegian','admin_acl','Lagre','form[15]');
INSERT INTO lang VALUES (195,'Members:','norwegian','admin_acl','Medlemmer:','form[64]');

