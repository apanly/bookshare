CREATE TABLE IF NOT EXISTS `book` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `isbn` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bartype` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `booknumber` int(1) NOT NULL DEFAULT '1',
  `creator` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `binding` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pages` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `pdate` date NOT NULL,
  `publisher` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lrdate` date NOT NULL,
  `clicknum` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL,
  `rentor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`,`uid`),
  KEY `clicknum` (`clicknum`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `bookdetail` (
  `bookid` int(10) NOT NULL,
  `booksummary` text COLLATE utf8_unicode_ci NOT NULL,
  `booktag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `id` (`bookid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `orderlist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `uname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bookid` int(10) NOT NULL,
  `flag` int(1) NOT NULL,
  `rentData` datetime NOT NULL,
  `backData` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `flag` (`flag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `userinfo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `roles` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`,`pwd`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `draftrecord` (
 `id` int(10) NOT NULL auto_increment,
 `content` text collate utf8_unicode_ci NOT NULL,
 `uid` int(10) NOT NULL,
 `idate` date NOT NULL,
 PRIMARY KEY  (`id`),
 KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

CREATE TABLE `lifemedia` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  `idate` datetime DEFAULT NULL,
  `openid` varchar(100) DEFAULT NULL,
  `type` int(1) DEFAULT '1' COMMENT '1=>image,2=>audio,3=>video',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `msgqueue` (
 `msgid` int(10) NOT NULL AUTO_INCREMENT,
 `openid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `msgtime` int(10) NOT NULL,
 `msgtype` int(1) NOT NULL,
 `fakeid` int(10) NOT NULL,
 `queueflag` int(1) NOT NULL DEFAULT '0' COMMENT '0=>not,1=>done',
 `wxmsgid` int(10) NOT NULL,
 PRIMARY KEY (`msgid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

CREATE TABLE `user_relation` (
 `openid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
 `fakeid` int(10) NOT NULL,
 `uid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;