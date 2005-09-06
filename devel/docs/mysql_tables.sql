-- MySQL dump 9.11
--
-- Host: localhost    Database: devel
-- ------------------------------------------------------
-- Server version	4.0.22-log

--
-- Table structure for table `Clan`
--

DROP TABLE IF EXISTS Clan;
CREATE TABLE Clan (
  ID int(11) NOT NULL auto_increment,
  name varchar(20) default NULL,
  password varchar(35) default NULL,
  about text,
  moderator int(11) default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `acls`
--

DROP TABLE IF EXISTS acls;
CREATE TABLE acls (
  groupID int(11) NOT NULL default '0',
  access varchar(20) NOT NULL default '',
  value smallint(1) default NULL,
  PRIMARY KEY  (groupID,access)
) TYPE=MyISAM;


DROP TABLE IF EXISTS statusTypes;
CREATE TABLE statusTypes (
  ID int(11) NOT NULL auto_increment,
  name varchar(35),
  PRIMARY KEY (ID)
) TYPE=MyISAM;


DROP TABLE IF EXISTS crewStatus;
CREATE TABLE crewStatus (
   userID int(11) NOT NULL default 1,
   status int(11) NOT NULL default 1,
   until int(5),
   PRIMARY KEY (userID)
) TYPE=MyISAM;
  


--
-- Table structure for table `compo`
--

DROP TABLE IF EXISTS compo;
CREATE TABLE compo (
  ID int(11) NOT NULL auto_increment,
  name varchar(25) default NULL,
  gameType tinyint(1) default NULL,
  players smallint(6) unsigned default NULL,
  rules text,
  roundPlayers smallint(2) default '2',
  isOpen tinyint(1) default '1',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `compoPoll`
--

DROP TABLE IF EXISTS compoPoll;
CREATE TABLE compoPoll (
  ID int(11) NOT NULL auto_increment,
  question varchar(50) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `compoPollA`
--

DROP TABLE IF EXISTS compoPollA;
CREATE TABLE compoPollA (
  pollID int(11) NOT NULL default '0',
  userID int(11) NOT NULL default '0',
  answer smallint(1) default NULL,
  moreinfo text,
  PRIMARY KEY  (pollID,userID)
) TYPE=MyISAM;

--
-- Table structure for table `compoReg`
--

DROP TABLE IF EXISTS compoReg;
CREATE TABLE compoReg (
  compoID int(11) NOT NULL default '0',
  userID int(11) NOT NULL default '0',
  clanID int(11) default NULL,
  seed mediumint(3) default '127',
  PRIMARY KEY  (compoID,userID)
) TYPE=MyISAM;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS config;
CREATE TABLE config (
  ID int(11) NOT NULL auto_increment,
  config varchar(32) NOT NULL default '',
  value varchar(32) NOT NULL default '',
  large text,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS faq;
CREATE TABLE faq (
  ID int(6) NOT NULL auto_increment,
  posted_by int(6) default NULL,
  question text,
  answer text,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS groups;
CREATE TABLE groups (
  ID int(11) NOT NULL auto_increment,
  groupname varchar(25) default NULL,
  publicName varchar(25) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table 'logs'
--

DROP TABLE IF EXISTS logs;
CREATE TABLE logs (
   ID int(11) NOT NULL auto_increment,
   userID int(11) NOT NULL default 0,
   userIP varchar(15) default '000.000.000.000',
   logType int(11) default 0,
   logWhat text,
   oldLog text,
   logUNIX int(25) default 0,
   PRIMARY KEY (ID)
) TYPE=MyISAM;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS news;
CREATE TABLE news (
  ID int(11) NOT NULL auto_increment,
  header text,
  logUNIX int(25) default 0,
  text text,
  poster int(11) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `partyweb`
--

DROP TABLE IF EXISTS partyweb;
CREATE TABLE partyweb (
  ID int(11) NOT NULL auto_increment,
  menuname varchar(64) default NULL,
  text text,
  display_menu tinyint(1) default '0',
  display_partymode tinyint(1) default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `pollA`
--

DROP TABLE IF EXISTS pollA;
CREATE TABLE pollA (
  AID int(6) NOT NULL auto_increment,
  QID int(6) default NULL,
  Atext text,
  votes int(6) default '0',
  PRIMARY KEY  (AID)
) TYPE=MyISAM;

--
-- Table structure for table `pollQ`
--

DROP TABLE IF EXISTS pollQ;
CREATE TABLE pollQ (
  ID int(6) NOT NULL auto_increment,
  text text,
  isOpen tinyint(1) default '1',
  maxVotes tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `pollVoted`
--

DROP TABLE IF EXISTS pollVoted;
CREATE TABLE pollVoted (
  voteID int(11) NOT NULL auto_increment,
  userID int(6) default NULL,
  pollID int(6) default NULL,
  PRIMARY KEY  (voteID)
) TYPE=MyISAM;

--
-- Table structure for table `random`
--

DROP TABLE IF EXISTS random;
CREATE TABLE random (
  ID int(11) NOT NULL auto_increment,
  text text NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `reserved`
--

DROP TABLE IF EXISTS reserved;
CREATE TABLE reserved (
  reservedBy int(11) default NULL,
  seatID int(11) default NULL,
  password varchar(11) default NULL
) TYPE=MyISAM;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS session;
CREATE TABLE session (
  sID varchar(32) NOT NULL default '',
  userID int(11) default NULL,
  IP varchar(15) default '000.000.000.000',
  logUNIX int(25) unsigned default '0',
  userURL varchar(100) default '',
  PRIMARY KEY  (sID)
) TYPE=MyISAM;

--
-- Table structure for table `static`
--

DROP TABLE IF EXISTS static;
CREATE TABLE static (
  ID int(11) NOT NULL auto_increment,
  header varchar(100) NOT NULL default '',
  text text NOT NULL,
  lastEdit varchar(25) default NULL,
  lastEditBy int(11) default NULL,
  showPage smallint(1) default '1',
  crewOnly smallint(1) default '0',
  useNL2BR smallint(1) default '1',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS stats;
CREATE TABLE stats (
  ID int(5) NOT NULL auto_increment,
  config varchar(60) default NULL,
  value varchar(100) default NULL,
  hits int(11) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table 'tasks'
--

DROP TABLE IF EXISTS tasks;
CREATE TABLE tasks (
  ID int(11) NOT NULL auto_increment,
  name varchar(50) default '',
  userID int(11) default 1,
  complete int(3) default 0,
  PRIMARY KEY(ID)
) TYPE=MyISAM;

--
-- Table structure for table 'tasks_log'
--

DROP TABLE IF EXISTS tasks_log;
CREATE TABLE tasks_log (
  ID int(11) NOT NULL auto_increment,
  taskID int(11) default 1,
  logUNIX int(25) default 0,
  logText text,
  userID int(11),
  PRIMARY KEY(ID)
) TYPE=MyISAM;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  ID int(11) NOT NULL auto_increment,
  name varchar(40) NOT NULL default '',
  firstName varchar(40) NOT NULL default '',
  lastName varchar(40) NOT NULL default '',
  nick varchar(25) NOT NULL default '',
  EMail varchar(50) NOT NULL default '',
  userDesign varchar(25) NOT NULL default 'default',
  password varchar(60) NOT NULL default '',
  verified int(6) default NULL,
  registered int(25) default '0',
  seatX int(4) default '-1',
  AllowPublic tinyint(1) default '0',
  aboutMe text,
  isHere tinyint(4) default '0',
  crewField text,
  cellphone varchar(20) default NULL,
  wannabe tinyint(1) NOT NULL default '0',
  wannabeDenied tinyint(1) NOT NULL default '0',
  seatY smallint(5) default '-1',
  street varchar(50) default NULL,
  postNr varchar(6) default NULL,
  postPlace varchar(25) default NULL,
  birthDAY varchar(5) default NULL,
  birthMONTH varchar(5) default NULL,
  birthYEAR varchar(5) default NULL,
  lastLoggedIn int(25) default '0',
  rememberMe smallint(1) default '0',
  ticketType smallint(2) default '0',
  ticketAuthorize smallint(2) default '1',
  netstatus int(1) default NULL,
  mac varchar(17) default NULL,
  hasvirus int(2) default NULL,
  myGroup int(11) default '2',
  loginComments text,
  loginColor smallint(1) default 0,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `waitinglist`
--

DROP TABLE IF EXISTS waitinglist;
CREATE TABLE waitinglist (
  ID int(11) NOT NULL auto_increment,
  userID int(11) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `lang`
--

DROP TABLE IF EXISTS lang;
CREATE TABLE lang (
  ID int(11) NOT NULL auto_increment, 
  string text NULL,
  language varchar(30) NOT NULL default 'english',
  module varchar(30),
  translated text NULL,
  extra text NULL,
  PRIMARY KEY (ID)
);

DROP TABLE IF EXISTS wannabeAlt;
CREATE TABLE `wannabeAlt` (
`ID` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`content` VARCHAR( 225 ) NOT NULL ,
`queID` INT( 10 ) NOT NULL ,
PRIMARY KEY ( `ID` )
) TYPE = MYISAM ;

DROP TABLE IF EXISTS wannabeQue;
CREATE TABLE `wannabeQue` (
`ID` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`content` VARCHAR( 225 ) NOT NULL ,
`type` SMALLINT(1) NOT NULL ,
PRIMARY KEY ( `ID` )
) TYPE = MYISAM ;

DROP TABLE IF EXISTS wannabeComment;
CREATE TABLE `wannabeComment` (
`ID` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`comment` text NOT NULL ,
approve smallint(1) NOT NULL default '0',
`user` INT(10) NOT NULL ,
`adminID` INT(10) NOT NULL ,
logUNIX int(25) unsigned default '0',
PRIMARY KEY ( `ID` )
) TYPE = MYISAM ;

DROP TABLE IF EXISTS wannabeUsers;
CREATE TABLE `wannabeUsers` (
`ID` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`user` VARCHAR( 225 ) NOT NULL ,
`ans` TEXT NOT NULL ,
`queID` INT( 10 ) NOT NULL ,
`catID` INT( 10 ) NOT NULL ,
logUNIX int(25) unsigned default '0',
PRIMARY KEY ( `ID` )
) TYPE = MYISAM ;

-- Adding kiosk-stuff

DROP TABLE IF EXISTS `kiosk_history_sales`;
CREATE TABLE `kiosk_history_sales` (
  `ID` int(11) NOT NULL auto_increment,
  `salesperson` int(11) default '1',
  `logUNIX` int(25) default '0',
  `wareID` varchar(50) default NULL,
  `warePrice` int(5) default NULL,
  `crewSalg` tinyint(1) default '0',
  `kasse` int(11) default '1',
  `rabatt` smallint(1) default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `history_salg_overall`
--

DROP TABLE IF EXISTS `kiosk_history_sales_overall`;
CREATE TABLE `kiosk_history_sales_overall` (
  `ID` int(11) NOT NULL auto_increment,
  `salesperson` int(11) default NULL,
  `crewsale` tinyint(1) default NULL,
  `money` int(10) default NULL,
  `box` int(11) default '1',
  `rabatt` smallint(1) default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `kasselog`
--

DROP TABLE IF EXISTS `kiosk_boxlog`;
CREATE TABLE `kiosk_boxlog` (
  `ID` int(11) NOT NULL auto_increment,
  `logtext` text,
  `logtime` int(15) default '0',
  `userID` int(11) default '1',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `kasser`
--

DROP TABLE IF EXISTS `kiosk_box`;
CREATE TABLE `kiosk_box` (
  `ID` int(11) NOT NULL auto_increment,
  `boxname` varchar(35) default '0',
  `content` int(10) default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `meny_innhold`
--

DROP TABLE IF EXISTS `kiosk_menu_content`;
CREATE TABLE `kiosk_menu_content` (
  `menuID` int(11) NOT NULL default '0',
  `wareID` int(11) NOT NULL default '0',
  `amount` tinyint(2) default '1',
  PRIMARY KEY  (`menuID`,`wareID`)
) TYPE=MyISAM;

--
-- Table structure for table `menyer`
--

DROP TABLE IF EXISTS `kiosk_menu`;
CREATE TABLE `kiosk_menu` (
  `ID` int(11) NOT NULL auto_increment,
  `menuname` varchar(35) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `rabatter`
--

DROP TABLE IF EXISTS `kiosk_rabatter`;
CREATE TABLE `kiosk_rabatter` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(35) default NULL,
  `active` smallint(1) default '0',
  `wareID` varchar(50) default NULL,
  `startTime` int(15) default '0',
  `stopTime` int(15) default '0',
  `newPrice` int(5) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;


--
-- Table structure for table `temp_kurv`
--

DROP TABLE IF EXISTS `temp_basket`;
CREATE TABLE `temp_basket` (
  `ID` int(11) NOT NULL auto_increment,
  `sID` varchar(50) default NULL,
  `wareID` varchar(50) default NULL,
  `amount` int(5) default '1',
  `unixtime` int(15) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;


--
-- Table structure for table `warez`
--

DROP TABLE IF EXISTS `kiosk_warez`;
CREATE TABLE `kiosk_warez` (
  `barcode` varchar(50) NOT NULL default '',
  `name` varchar(50) default NULL,
  `price` int(5) default NULL,
  `cPrice` int(5) default '0',
  `inPrice` int(5) default '0',
  `active` smallint(1) default '1',
  PRIMARY KEY  (`barcode`)
) TYPE=MyISAM;




INSERT INTO users SET ID = 1, name = 'Guestuser', nick = 'NoUser', myGroup = 0;
INSERT INTO users SET ID = 2, myGroup = 3, name= 'Admin', nick = 'admin', password = '21232f297a57a5a743894a0e4a801fc3';
INSERT INTO static SET header = 'index', text = 'Welcome to your new installation of OSGlobeLAN. Login as admin with password admin to make changes to the settings. Of course, youve already read all the docs in docs/ ;)';

INSERT INTO groups SET ID = 1, groupname = 'Anonymous';
INSERT INTO groups SET ID = 2, groupname = 'User';
INSERT INTO groups SET ID = 3, groupname = 'Superuser';
INSERT INTO acls SET groupID = 3, access = 'root', value = 1;

-- Add something into the polldatabase...
INSERT INTO pollQ SET ID = 1, text = 'Do you like this system?', isOpen = 1, maxVotes = 1;
INSERT INTO pollA SET QID = 1, Atext = 'YES!', votes = 5;
INSERT INTO pollA SET QID = 1, Atext = 'OOOOOOOOOOH YES!!!', votes = 5000;

-- No need to create a query just to check if this exists?
INSERT INTO stats SET config = 'hits', value = 'pageviews', hits = 0;
INSERT INTO stats SET config = 'hits', value = 'total', hits = 0;

-- Adding the default status with "nothing"
INSERT INTO statusTypes SET ID = 1, name = '';

-- Adding the default kiosk-money-box
INSERT INTO kiosk_box SET ID = 1, boxname = 'Default Moneybox', content = 0;

