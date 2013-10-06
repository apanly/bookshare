CREATE TABLE `book` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `isbn` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bartype` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `creator` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `binding` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pages` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `pdate` date NOT NULL,
  `publisher` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lrdate` date NOT NULL,
  `clicknum` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `isbn` (`isbn`,`uid`),
   KEY `clicknum` (`clicknum`),
   KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

CREATE TABLE `userinfo` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
 `pwd` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
 `roles` int(1) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `username` (`username`,`pwd`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci