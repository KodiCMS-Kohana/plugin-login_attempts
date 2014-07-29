CREATE TABLE `__TABLE_PREFIX__login_attempts` (
  `ip` varchar(20) NOT NULL,
  `attempts` int(11) NOT NULL default '0',
  `last_login` datetime NOT NULL default  '0000-00-00 00:00:00',
  PRIMARY KEY  (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;