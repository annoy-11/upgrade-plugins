<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eandroidstories
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: defaultsettings.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$db->query('DELETE FROM `engine4_core_menuitems` WHERE `engine4_core_menuitems`.`name` = "core_admin_main_plugins_sesstories";');
$db->query('DELETE FROM `engine4_core_menuitems` WHERE `engine4_core_menuitems`.`name` = "sesstories_admin_main_settings";');
$db->query('DELETE FROM `engine4_core_menuitems` WHERE `engine4_core_menuitems`.`name` = "sesstories_admin_main_manage";');
