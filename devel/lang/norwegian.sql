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
INSERT INTO lang VALUES (153,'Main Page','norwegian','style_menu','Hovedsiden','menuitem in write_menu');
INSERT INTO lang VALUES (154,'News','norwegian','style_menu','Nyheter','menuitem in write_menu');
INSERT INTO lang VALUES (155,'Register','norwegian','style_menu','Registrer bruker','menuitem in write_menu');
INSERT INTO lang VALUES (156,'Forum','norwegian','style_menu','Forum','menuitem in write_menu');
INSERT INTO lang VALUES (157,'Statistics','norwegian','style_menu','Statestikk','Menuitem for stats');
INSERT INTO lang VALUES (158,'Edit profile','norwegian','style_menu','Rediger profil','menuitem in write_menu');
INSERT INTO lang VALUES (159,'WannabeCrew','norwegian','style_menu','WannabeCrew','menuitem in write_menu');
INSERT INTO lang VALUES (160,'Userlogin','norwegian','style_menu','Brukerinnlogging','menuitem in write_menu');
INSERT INTO lang VALUES (161,'Crewaddressbook','norwegian','style_menu','Crew Adressebok','menuitem in write_menu');
INSERT INTO lang VALUES (162,'ADMIN','norwegian','style_menu','ADMIN','menuitem in write_menu');
INSERT INTO lang VALUES (163,'Logout','norwegian','style_menu','Logg ut','menuitem in write_menu');
INSERT INTO lang VALUES (164,'View Users','norwegian','admin_wannabemin','List Brukere','Text to display in wannabemin&action=ViewUsers');
INSERT INTO lang VALUES (165,'Nick: ','norwegian','admin_wannabemin','Nick: ','DoViewUsers->profile->nick');
INSERT INTO lang VALUES (166,'Name: ','norwegian','admin_wannabemin','Navn: ','DoViewUsers->profile->name');
INSERT INTO lang VALUES (167,'Birthday: ','norwegian','admin_wannabemin','Fødselsdag: ','DoViewUsers->profile->birthday');
INSERT INTO lang VALUES (168,'EMail: ','norwegian','admin_wannabemin','E-Post: ','DoViewUsers->profile->EMail');
INSERT INTO lang VALUES (169,'Cellphone: ','norwegian','admin_wannabemin','Mobiltelefon: ','DoViewUsers->profile->Cellphone');
INSERT INTO lang VALUES (170,'Street: ','norwegian','admin_wannabemin','Gateadresse: ','DoViewUsers->profile->Street');
INSERT INTO lang VALUES (171,'Post # / place: ','norwegian','admin_wannabemin','Postnummer/sted','DoViewUsers->profile->poststuff');
INSERT INTO lang VALUES (172,'Question:','norwegian','admin_wannabemin','Spørsmål:','Text to display in wannabemin&action=DoViewUsers');
INSERT INTO lang VALUES (173,'Add comment:','norwegian','admin_wannabemin','Legg til kommentar:','Text to display in wannabemin&action=DoViewUsers');
INSERT INTO lang VALUES (174,'Do You like this wannabe ?','norwegian','admin_wannabemin','Liker du denne wannaben?','Text to display in wannabemin&action=DoViewUsers');
INSERT INTO lang VALUES (175,'Yes','norwegian','admin_wannabemin','Ja','Text to display in wannabemin&action=DoViewUsers');
INSERT INTO lang VALUES (176,'Not decided yet','norwegian','admin_wannabemin','Ikke bestemt meg ennå','Text to display in wannabemin&action=DoViewUsers');
INSERT INTO lang VALUES (177,'Nope','norwegian','admin_wannabemin','Nei','Text to display in wannabemin&action=DoViewUsers');
INSERT INTO lang VALUES (178,'Add','norwegian','admin_wannabemin','Legg til','Text used in wannabemin');
INSERT INTO lang VALUES (179,'The seatreservation has not yet opened!','norwegian','seat','Plassregistrering har ikke åpnet ennå!','Text to display when the seatreg has not opened yet');
INSERT INTO lang VALUES (180,'Add question','norwegian','admin_wannabemin','Legg til spørsmål','Text to display in wannabe admin menu');
INSERT INTO lang VALUES (181,'Comment added','norwegian','admin_wannabemin','Kommentar lagt til','Text used in wannabemin');
INSERT INTO lang VALUES (182,'DIIIIIIIIIIIIIE!! No access!','norwegian','inc_adressbook','DØØØØØØØØØ!!! Ingen tilgang!','No access-text in addressbook');

