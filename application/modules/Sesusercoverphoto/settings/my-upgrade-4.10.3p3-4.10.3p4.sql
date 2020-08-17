UPDATE `engine4_authorization_permissions` SET `name` = 'defaultcover' WHERE `engine4_authorization_permissions`.`name` = 'defaultcoverphoto';
UPDATE `engine4_authorization_permissions` SET `type` = 'sesusercover' WHERE `engine4_authorization_permissions`.`type` = 'sesusercoverphoto';
UPDATE `engine4_core_menuitems` SET `label` = 'Cover Photo ML Settings' WHERE `engine4_core_menuitems`.`name` = 'sesusercoverphoto_admin_main_level';
