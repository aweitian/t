CREATE TABLE `blkwords` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT NULL,
  `word` text,
  `url` text,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8

CREATE TABLE `results` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(1024) NOT NULL,
  `result` int(11) NOT NULL DEFAULT '4',
  `ma_word` varchar(256) NOT NULL,
  `rawhtml` text NOT NULL,
  `str_content` text NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8

CREATE TABLE `user` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `role` varchar(16) NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8

--DEBUG USER
INSERT INTO `user` (`name`, `pass`, `role`) VALUES ('Apocalypse', '49214f5c87c77c2f14600e6ad0deb03d', 'debug');
