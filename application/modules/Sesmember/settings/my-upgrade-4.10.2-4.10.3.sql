INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesmember_admin_main_adminpicks", "sesmember", "Admin Picks Members", "", '{"route":"admin_default","module":"sesmember","controller":"manage", "action":"admin-picks"}', "sesmember_admin_main", "", 999),
("sesmember_main_editormembers", "sesmember", "Editor Members", "", '{"route":"sesmember_general","action":"editormembers"}', "sesmember_main", "", 999);

ALTER TABLE `engine4_users` ADD `adminpicks` TINYINT(1) NOT NULL DEFAULT "0", ADD `order` INT(11) NOT NULL DEFAULT "0";