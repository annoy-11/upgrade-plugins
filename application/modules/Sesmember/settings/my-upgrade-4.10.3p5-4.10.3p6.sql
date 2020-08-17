ALTER TABLE `engine4_sesmember_follows` ADD `resource_approved` TINYINT(1) NOT NULL DEFAULT '0' AFTER `creation_date`, ADD `user_approved` TINYINT(1) NOT NULL DEFAULT '0' AFTER `resource_approved`;

INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`, `default`) VALUES 
("sesmember_follow_request", "sesmember", '{item:$subject} send you follow request.', "0", "", "1"),
("sesmember_follow_requestaccept", "sesmember", '{item:$subject} accept your follow request.', "0", "", "1");
