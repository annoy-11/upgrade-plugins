ALTER TABLE `engine4_sesquote_quotes` ADD `quotetitle` VARCHAR(255) NULL;

ALTER TABLE `engine4_sesquote_quotes` ADD `mediatype` TINYINT(1) NOT NULL DEFAULT "1";

ALTER TABLE `engine4_sesquote_quotes` ADD `code` TEXT NOT NULL;