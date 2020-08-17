CREATE TABLE IF NOT EXISTS `engine4_sesemailverification_verifications` (
  `verification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sesemailverified` TINYINT(1) NOT NULL DEFAULT "0",
  PRIMARY KEY (`verification_id`),
  UNIQUE( `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

INSERT IGNORE INTO engine4_sesemailverification_verifications (`user_id`, `sesemailverified`) SELECT `user_id`, `sesemailverified` FROM engine4_users as t ON DUPLICATE KEY UPDATE user_id=t.user_id, sesemailverified=t.sesemailverified;
