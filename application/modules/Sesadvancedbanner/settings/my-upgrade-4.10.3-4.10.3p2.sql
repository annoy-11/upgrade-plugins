
ALTER TABLE `engine4_sesadvancedbanner_slides` ADD `overlay_pettern` VARCHAR(50) DEFAULT NULL;
ALTER TABLE `engine4_sesadvancedbanner_slides` ADD `overlay_type` TINYINT(1) NOT NULL DEFAULT "1"  AFTER overlay_pettern;