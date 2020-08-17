UPDATE `engine4_core_menuitems` SET `label` = 'Cover Video ML Settings' WHERE `engine4_core_menuitems`.`name` = 'sesusercovervideo_admin_main_level';
UPDATE `engine4_authorization_permissions` SET `name` = 'defaultcovephoto' WHERE `engine4_authorization_permissions`.`name` = 'defaultcoverphoto';
UPDATE `engine4_authorization_permissions` SET `type` = 'sesusercovevideo' WHERE `engine4_authorization_permissions`.`type` = 'sesusercovervideo';
ALTER TABLE `engine4_sesusercovervideo_videos` ADD `cover_video` INT(11) NOT NULL DEFAULT "0";
