ALTER TABLE `engine4_sesprayer_prayers` ADD `prayertitle` VARCHAR(255) NULL;

ALTER TABLE `engine4_sesprayer_prayers` ADD `mediatype` TINYINT(1) NOT NULL DEFAULT "1";

ALTER TABLE `engine4_sesprayer_prayers` ADD `code` TEXT NOT NULL;