ALTER TABLE `engine4_sesprayer_prayers` ADD `posttype` TINYINT(1) NOT NULL DEFAULT '1' AFTER `code`, ADD `networks` VARCHAR(255) NULL AFTER `posttype`;
ALTER TABLE `engine4_sesprayer_prayers` ADD `lists` VARCHAR(255) NULL AFTER `networks`;
INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("sesprayer_sendprayer", "sesprayer", '{item:$subject} has sent you a prayer {item:$object}.', 0, "");
ALTER TABLE `engine4_sesprayer_prayers` ADD `user_id` INT(11) NOT NULL DEFAULT '02' COMMENT "Friend Id";
