-- MySQL dump 9.11
--
-- Host: localhost    Database: devel
-- ------------------------------------------------------
-- Server version	4.0.24_Debian-10-log

--
-- Table structure for table `Clan`
--

CREATE TABLE `Clan` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(20) default NULL,
  `password` varchar(35) default NULL,
  `about` text,
  `moderator` int(11) default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `acls`
--

CREATE TABLE `acls` (
  `groupID` int(11) NOT NULL default '0',
  `access` varchar(20) NOT NULL default '',
  `value` smallint(1) default NULL,
  PRIMARY KEY  (`groupID`,`access`)
) TYPE=MyISAM;

--
-- Table structure for table `compo`
--

CREATE TABLE `compo` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(25) default NULL,
  `gameType` tinyint(1) default NULL,
  `players` smallint(6) unsigned default NULL,
  `rules` text,
  `roundPlayers` smallint(2) default '2',
  `isOpen` tinyint(1) default '1',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `compoPoll`
--

CREATE TABLE `compoPoll` (
  `ID` int(11) NOT NULL auto_increment,
  `question` varchar(50) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `compoPollA`
--

CREATE TABLE `compoPollA` (
  `pollID` int(11) NOT NULL default '0',
  `userID` int(11) NOT NULL default '0',
  `answer` smallint(1) default NULL,
  `moreinfo` text,
  PRIMARY KEY  (`pollID`,`userID`)
) TYPE=MyISAM;

--
-- Table structure for table `compoReg`
--

CREATE TABLE `compoReg` (
  `compoID` int(11) NOT NULL default '0',
  `userID` int(11) NOT NULL default '0',
  `clanID` int(11) default NULL,
  `seed` mediumint(3) default '127',
  PRIMARY KEY  (`compoID`,`userID`)
) TYPE=MyISAM;

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `ID` int(11) NOT NULL auto_increment,
  `config` varchar(32) NOT NULL default '',
  `value` varchar(32) NOT NULL default '',
  `large` text,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `crewStatus`
--

CREATE TABLE `crewStatus` (
  `userID` int(11) NOT NULL default '1',
  `status` int(11) NOT NULL default '1',
  `until` int(5) default NULL,
  PRIMARY KEY  (`userID`)
) TYPE=MyISAM;

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `ID` int(6) NOT NULL auto_increment,
  `posted_by` int(6) default NULL,
  `question` text,
  `answer` text,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `ID` int(11) NOT NULL auto_increment,
  `groupname` varchar(25) default NULL,
  `publicName` varchar(25) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `kiosk_box`
--

CREATE TABLE `kiosk_box` (
  `ID` int(11) NOT NULL auto_increment,
  `boxname` varchar(35) default '0',
  `content` int(10) default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `kiosk_boxlog`
--

CREATE TABLE `kiosk_boxlog` (
  `ID` int(11) NOT NULL auto_increment,
  `logtext` text,
  `logtime` int(15) default '0',
  `userID` int(11) default '1',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `kiosk_history_sales`
--

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
-- Table structure for table `kiosk_history_sales_overall`
--

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
-- Table structure for table `kiosk_menu`
--

CREATE TABLE `kiosk_menu` (
  `ID` int(11) NOT NULL auto_increment,
  `menuname` varchar(35) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `kiosk_menu_content`
--

CREATE TABLE `kiosk_menu_content` (
  `menuID` int(11) NOT NULL default '0',
  `wareID` int(11) NOT NULL default '0',
  `amount` tinyint(2) default '1',
  PRIMARY KEY  (`menuID`,`wareID`)
) TYPE=MyISAM;

--
-- Table structure for table `kiosk_rabatter`
--

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
-- Table structure for table `kiosk_warez`
--

CREATE TABLE `kiosk_warez` (
  `barcode` varchar(50) NOT NULL default '',
  `name` varchar(50) default NULL,
  `price` int(5) default NULL,
  `cPrice` int(5) default '0',
  `inPrice` int(5) default '0',
  `active` smallint(1) default '1',
  PRIMARY KEY  (`barcode`)
) TYPE=MyISAM;

--
-- Table structure for table `lang`
--

CREATE TABLE `lang` (
  `ID` int(11) NOT NULL auto_increment,
  `string` text,
  `language` varchar(30) NOT NULL default 'english',
  `module` varchar(30) default NULL,
  `translated` text,
  `extra` text,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `ID` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL default '0',
  `userIP` varchar(15) default '000.000.000.000',
  `logType` int(11) default '0',
  `logWhat` text,
  `oldLog` text,
  `logUNIX` int(25) default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL auto_increment,
  `header` text,
  `logUNIX` int(25) default '0',
  `text` text,
  `poster` int(11) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `partyweb`
--

CREATE TABLE `partyweb` (
  `ID` int(11) NOT NULL auto_increment,
  `menuname` varchar(64) default NULL,
  `text` text,
  `display_menu` tinyint(1) default '0',
  `display_partymode` tinyint(1) default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `pollA`
--

CREATE TABLE `pollA` (
  `AID` int(6) NOT NULL auto_increment,
  `QID` int(6) default NULL,
  `Atext` text,
  `votes` int(6) default '0',
  PRIMARY KEY  (`AID`)
) TYPE=MyISAM;

--
-- Table structure for table `pollQ`
--

CREATE TABLE `pollQ` (
  `ID` int(6) NOT NULL auto_increment,
  `text` text,
  `isOpen` tinyint(1) default '1',
  `maxVotes` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `pollVoted`
--

CREATE TABLE `pollVoted` (
  `voteID` int(11) NOT NULL auto_increment,
  `userID` int(6) default NULL,
  `pollID` int(6) default NULL,
  PRIMARY KEY  (`voteID`)
) TYPE=MyISAM;

--
-- Table structure for table `random`
--

CREATE TABLE `random` (
  `ID` int(11) NOT NULL auto_increment,
  `text` text NOT NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `reserved`
--

CREATE TABLE `reserved` (
  `reservedBy` int(11) default NULL,
  `seatID` int(11) default NULL,
  `password` varchar(11) default NULL
) TYPE=MyISAM;

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `sID` varchar(32) NOT NULL default '',
  `userID` int(11) default NULL,
  `IP` varchar(15) default '000.000.000.000',
  `logUNIX` int(25) unsigned default '0',
  `userURL` varchar(100) default '',
  `crewSale` tinyint(1) default '0',
  `kiosk_box` tinyint(1) default '1',
  PRIMARY KEY  (`sID`)
) TYPE=MyISAM;

--
-- Table structure for table `static`
--

CREATE TABLE `static` (
  `ID` int(11) NOT NULL auto_increment,
  `header` varchar(100) NOT NULL default '',
  `text` text NOT NULL,
  `lastEdit` varchar(25) default NULL,
  `lastEditBy` int(11) default NULL,
  `showPage` smallint(1) default '1',
  `crewOnly` smallint(1) default '0',
  `useNL2BR` smallint(1) default '1',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `ID` int(5) NOT NULL auto_increment,
  `config` varchar(60) default NULL,
  `value` varchar(100) default NULL,
  `hits` int(11) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `statusTypes`
--

CREATE TABLE `statusTypes` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(35) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(50) default '',
  `userID` int(11) default '1',
  `complete` int(3) default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `tasks_log`
--

CREATE TABLE `tasks_log` (
  `ID` int(11) NOT NULL auto_increment,
  `taskID` int(11) default '1',
  `logUNIX` int(25) default '0',
  `logText` text,
  `userID` int(11) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `temp_basket`
--

CREATE TABLE `temp_basket` (
  `ID` int(11) NOT NULL auto_increment,
  `sID` varchar(50) default NULL,
  `wareID` varchar(50) default NULL,
  `amount` int(5) default '1',
  `unixtime` int(15) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL default '',
  `firstName` varchar(40) NOT NULL default '',
  `lastName` varchar(40) NOT NULL default '',
  `nick` varchar(25) NOT NULL default '',
  `EMail` varchar(50) NOT NULL default '',
  `userDesign` varchar(25) NOT NULL default 'default',
  `password` varchar(60) NOT NULL default '',
  `verified` int(6) default NULL,
  `registered` int(25) default '0',
  `seatX` int(4) default '-1',
  `AllowPublic` tinyint(1) default '0',
  `aboutMe` text,
  `isHere` tinyint(4) default '0',
  `crewField` text,
  `cellphone` varchar(20) default NULL,
  `wannabe` tinyint(1) NOT NULL default '0',
  `wannabeDenied` tinyint(1) NOT NULL default '0',
  `seatY` smallint(5) default '-1',
  `street` varchar(50) default NULL,
  `postNr` varchar(6) default NULL,
  `postPlace` varchar(25) default NULL,
  `birthDAY` varchar(5) default NULL,
  `birthMONTH` varchar(5) default NULL,
  `birthYEAR` varchar(5) default NULL,
  `lastLoggedIn` int(25) default '0',
  `rememberMe` smallint(1) default '0',
  `ticketType` smallint(2) default '0',
  `ticketAuthorize` smallint(2) default '1',
  `netstatus` int(1) default NULL,
  `mac` varchar(17) default NULL,
  `hasvirus` int(2) default NULL,
  `myGroup` int(11) default '2',
  `loginComments` text,
  `loginColor` smallint(1) default '0',
  `tempPassword` varchar(32) NOT NULL default '',
  `lastPasswordReset` int(25) NOT NULL default '0',
  `userCheckbox1` smallint(1) default '0',
  `userCheckbox2` smallint(1) default '0',
  `userCheckbox3` smallint(1) default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `waitinglist`
--

CREATE TABLE `waitinglist` (
  `ID` int(11) NOT NULL auto_increment,
  `userID` int(11) default NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `wannabeAlt`
--

CREATE TABLE `wannabeAlt` (
  `ID` int(10) NOT NULL auto_increment,
  `content` varchar(225) NOT NULL default '',
  `queID` int(10) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `wannabeComment`
--

CREATE TABLE `wannabeComment` (
  `ID` int(10) NOT NULL auto_increment,
  `comment` text NOT NULL,
  `approve` smallint(1) NOT NULL default '0',
  `user` int(10) NOT NULL default '0',
  `adminID` int(10) NOT NULL default '0',
  `logUNIX` int(25) unsigned default '0',
  display tinyint(1) default 0,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `wannabeQue`
--

CREATE TABLE `wannabeQue` (
  `ID` int(10) NOT NULL auto_increment,
  `content` varchar(225) NOT NULL default '',
  `type` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `wannabeUsers`
--

CREATE TABLE `wannabeUsers` (
  `ID` int(10) NOT NULL auto_increment,
  `user` varchar(225) NOT NULL default '',
  `ans` text NOT NULL,
  `queID` int(10) NOT NULL default '0',
  `catID` int(10) NOT NULL default '0',
  `logUNIX` int(25) unsigned default '0',
  PRIMARY KEY  (`ID`)
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

