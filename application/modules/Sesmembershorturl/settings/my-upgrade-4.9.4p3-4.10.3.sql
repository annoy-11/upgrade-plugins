
UPDATE `engine4_core_menuitems` SET `name` = 'core_admin_main_plugins_sesmerurl' WHERE `engine4_core_menuitems`.`name` = 'core_admin_main_plugins_sesmembershorturl';

UPDATE `engine4_authorization_permissions` SET `type` = 'sesmerurl' WHERE `engine4_authorization_permissions`.`type` = 'sesmembershorturl';
