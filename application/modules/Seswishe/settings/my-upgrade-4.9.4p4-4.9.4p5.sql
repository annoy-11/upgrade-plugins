ALTER TABLE `engine4_seswishe_wishes` ADD `wishetitle` VARCHAR(255) NULL;

ALTER TABLE `engine4_seswishe_wishes` ADD `mediatype` TINYINT(1) NOT NULL DEFAULT "1";

ALTER TABLE `engine4_seswishe_wishes` ADD `code` TEXT NOT NULL;