INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sescontest_admin_packagesetting", "sescontestpackage", "Package Settings", "", '{"route":"admin_default","module":"sescontestpackage","controller":"package","action":"settings"}', "sescontest_admin_main", "", 2),
("sescontest_admin_subpackagesetting", "sescontestpackage", "Package Settings", "", '{"route":"admin_default","module":"sescontestpackage","controller":"package","action":"settings"}', "sescontest_admin_packagesetting", "", 1),
("sescontest_main_manage_package", "sescontest", "My Packages", "Sescontest_Plugin_Menus", '{"route":"sescontest_general","action":"package"}', "sescontest_main", "", 7);

