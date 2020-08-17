DROP TABLE IF EXISTS `engine4_sesspectromedia_headerphotos`;
CREATE TABLE IF NOT EXISTS `engine4_sesspectromedia_headerphotos` (
  `headerphoto_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT '0',
  `order` tinyint(10) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) DEFAULT '1',
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`headerphoto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;