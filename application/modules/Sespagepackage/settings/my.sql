INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sespage_admin_packagesetting", "sespagepackage", "Package Settings", "", '{"route":"admin_default","module":"sespagepackage","controller":"package","action":"settings"}', "sespage_admin_main", "", 2),
("sespage_admin_subpackagesetting", "sespagepackage", "Package Settings", "", '{"route":"admin_default","module":"sespagepackage","controller":"package","action":"settings"}', "sespage_admin_packagesetting", "", 1),
("sespage_main_manage_package", "sespage", "My Packages", "Sespage_Plugin_Menus", '{"route":"sespage_general","action":"package"}', "sespage_main", "", 7);

