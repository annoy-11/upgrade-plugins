ALTER TABLE `engine4_sespage_categories` ADD `member_levels` VARCHAR(255) NULL DEFAULT NULL;
UPDATE `engine4_sespage_categories` SET `member_levels` = '1,2,3,4' WHERE `engine4_sespage_categories`.`subcat_id` = 0 and  `engine4_sespage_categories`.`subsubcat_id` = 0;
