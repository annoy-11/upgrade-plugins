DROP TABLE IF EXISTS `engine4_sesprayer_receivers`;
CREATE TABLE `engine4_sesprayer_receivers` (
  `receiver_id` int(11) unsigned NOT NULL auto_increment,
  `prayer_id` int(11) unsigned NOT NULL,
  `sender_id` int(11) unsigned NOT NULL,
  `resource_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`receiver_id`),
  KEY `prayer_id` (`prayer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;
