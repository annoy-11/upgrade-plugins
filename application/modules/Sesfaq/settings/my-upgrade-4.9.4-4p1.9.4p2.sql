INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
("sesfaq_main", "standard", "SES - Multi - Use FAQs - Main Navigation Menu");

INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
('sesfaq_new', 'sesfaq', '{item:$subject} posted a new FAQ {item:$object}:', 1, 5, 1, 3, 1, 1);