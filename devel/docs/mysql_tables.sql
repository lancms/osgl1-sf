-- MySQL dump 9.09
--
-- Host: localhost    Database: devel
-- ------------------------------------------------------
-- Server version	4.0.16-log

--
-- Table structure for table `Clan`
--

CREATE TABLE Clan (
  ID int(11) NOT NULL auto_increment,
  name varchar(20) default NULL,
  password varchar(35) default NULL,
  about text,
  moderator int(11) default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `compo`
--

CREATE TABLE compo (
  ID int(11) NOT NULL auto_increment,
  name varchar(25) default NULL,
  caption text,
  gameType varchar(20) default NULL,
  players smallint(6) unsigned default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `compoReg`
--

CREATE TABLE compoReg (
  compoID int(11) default NULL,
  clanID int(11) default NULL,
  userID int(11) default NULL
) TYPE=MyISAM;

--
-- Table structure for table `config`
--

CREATE TABLE config (
  ID int(11) NOT NULL auto_increment,
  config varchar(32) NOT NULL default '',
  value varchar(32) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `faq`
--

CREATE TABLE faq (
  ID int(6) NOT NULL auto_increment,
  posted_by int(6) default NULL,
  question text,
  answer text,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `forumCats`
--

CREATE TABLE forumCats (
  ID int(11) NOT NULL auto_increment,
  crewOnly tinyint(1) default NULL,
  name text,
  info text,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `forumPosts`
--

CREATE TABLE forumPosts (
  ID int(11) NOT NULL auto_increment,
  poster int(11) default NULL,
  date datetime default NULL,
  IP varchar(15) default NULL,
  text text NOT NULL,
  threadID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `forumThread`
--

CREATE TABLE forumThread (
  ID int(11) NOT NULL auto_increment,
  header varchar(50) default NULL,
  poster int(11) default NULL,
  date datetime default NULL,
  catID int(11) NOT NULL default '0',
  lastPostDate int(11) default '0',
  lastPost varchar(11) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `kiosk_temp`
--

CREATE TABLE kiosk_temp (
  ID int(11) NOT NULL auto_increment,
  nick varchar(25) default NULL,
  number int(3) default NULL,
  ware int(11) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `kiosk_warez`
--

CREATE TABLE kiosk_warez (
  ID int(11) NOT NULL auto_increment,
  name varchar(25) default NULL,
  price int(4) default NULL,
  stock varchar(25) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `news`
--

CREATE TABLE news (
  ID int(11) NOT NULL auto_increment,
  header text,
  text text,
  poster int(11) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `partyweb`
--

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

CREATE TABLE pollA (
  AID int(6) NOT NULL auto_increment,
  QID int(6) default NULL,
  Atext text,
  votes tinyint(6) default '0',
  PRIMARY KEY  (AID)
) TYPE=MyISAM;

--
-- Table structure for table `pollQ`
--

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

CREATE TABLE pollVoted (
  voteID int(11) NOT NULL auto_increment,
  userID int(6) default NULL,
  pollID int(6) default NULL,
  PRIMARY KEY  (voteID)
) TYPE=MyISAM;

--
-- Table structure for table `random`
--

CREATE TABLE random (
  ID int(11) NOT NULL auto_increment,
  text text NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `reserved`
--

CREATE TABLE reserved (
  reservedBy int(11) default NULL,
  seatID int(11) default NULL,
  password varchar(11) default NULL
) TYPE=MyISAM;

--
-- Table structure for table `session`
--

CREATE TABLE session (
  sID varchar(32) NOT NULL default '',
  userID int(11) default NULL,
  IP varchar(15) default '000.000.000.000',
  logUNIX int(25) unsigned default '0',
  PRIMARY KEY  (sID)
) TYPE=MyISAM;

--
-- Table structure for table `static`
--

CREATE TABLE static (
  ID int(11) NOT NULL auto_increment,
  header varchar(100) NOT NULL default '',
  text text NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `stats`
--

CREATE TABLE stats (
  ID int(5) NOT NULL auto_increment,
  config varchar(30) default NULL,
  value varchar(30) default NULL,
  hits int(11) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `users`
--

CREATE TABLE users (
  ID int(11) NOT NULL auto_increment,
  name varchar(40) NOT NULL default '',
  nick varchar(25) NOT NULL default '',
  EMail varchar(50) NOT NULL default '',
  userDesign varchar(25) NOT NULL default 'default',
  password varchar(60) NOT NULL default '',
  isCrew tinyint(1) NOT NULL default '0',
  verified int(6) default NULL,
  registered datetime default '0000-00-00 00:00:00',
  seatID int(11) default '0',
  AllowPublic tinyint(1) default '0',
  aboutMe text,
  isHere tinyint(4) default '0',
  crewField text,
  cellphone int(11) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Table structure for table `waitinglist`
--

CREATE TABLE waitinglist (
  ID int(11) NOT NULL auto_increment,
  userID int(11) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

INSERT INTO users SET ID = 1, name = 'Anonymous', nick = 'guest';
