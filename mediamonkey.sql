CREATE TABLE IF NOT EXISTS `stats` (
  `user` varchar(20) DEFAULT NULL,
  `idMovie` int(11) DEFAULT NULL,
  `dttm` datetime DEFAULT NULL,
  `stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(8) DEFAULT NULL,
  `file` varchar(256) NOT NULL,
  `med_type` varchar(5) NOT NULL,
  PRIMARY KEY (`stat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;
