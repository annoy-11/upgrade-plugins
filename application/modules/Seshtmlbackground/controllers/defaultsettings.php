<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seshtmlbackground
 * @package    Seshtmlbackground
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`,`params`, `menu`, `submenu`, `order`) VALUES ("seshtmkbackground_admin_main_utility", "seshtmlbackground", "Utilities", "", \'{"route":"admin_default","module":"seshtmlbackground","controller":"settings","action":"utility"}\', "seshtmlbackground_admin_main", "", 2);');
$db->query('INSERT IGNORE INTO `engine4_core_jobtypes` (`title`, `type`, `module`, `plugin`, `enabled`, `multi`, `priority`) VALUES ("Ses Html Background Encode", "seshtmlbackground_video_encode", "seshtmlbackground", "Seshtmlbackground_Plugin_Job_Encode", 1, 2, 85);');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides`  ADD `status` ENUM("1","2","3") NOT NULL DEFAULT "1";');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `extra_button_linkopen` TINYINT(1) NOT NULL DEFAULT "0";');

$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `show_login_form` TINYINT(1) NOT NULL DEFAULT "0";');

$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `overlay_color` varchar(25) NOT NULL DEFAULT "FFFFFF";');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `overlay_opacity` float(11) NOT NULL DEFAULT "0.3";');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `title_font_size` INT(11) NOT NULL DEFAULT "14";');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `title_font_family` VARCHAR(50) NOT NULL DEFAULT "ABeeZee";');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `description_font_size` INT(11) NOT NULL DEFAULT "14";');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `description_font_family` VARCHAR(50) NOT NULL DEFAULT "ABeeZee";');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `youtube_video_link` VARCHAR(255) DEFAULT NULL;');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `youtube_video_code` TEXT DEFAULT NULL;');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `overlay_pettern` VARCHAR(50) DEFAULT NULL;');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `overlay_type` TINYINT(1) NOT NULL DEFAULT "1"  AFTER overlay_pettern;');
$db->query('ALTER TABLE `engine4_seshtmlbackground_galleries` ADD `enabled` TINYINT(1) NOT NULL DEFAULT "1";');
$db->query('ALTER TABLE `engine4_seshtmlbackground_slides` ADD `enabled` TINYINT(1) NOT NULL DEFAULT "1";');











