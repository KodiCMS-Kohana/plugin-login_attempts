CREATE TABLE `__TABLE_PREFIX__user_login_attempts` (
  `ip` varchar(20) NOT NULL DEFAULT '0.0.0.0',
  `attempts` int(11) NOT NULL default '0',
  `last_login` datetime NOT NULL default  '0000-00-00 00:00:00',
  PRIMARY KEY  (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `__TABLE_PREFIX__user_ips` (
  `ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `blocked` tinyint(2) NOT NULL DEFAULT '0',
  `count` int(10) NOT NULL DEFAULT '0',
  `last_login` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;