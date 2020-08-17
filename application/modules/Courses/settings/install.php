<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: install.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Installer extends Engine_Package_Installer_Module {
  public function onInstall() { 
    $db = $this->getDb();
    parent::onInstall();
  }
   public function onDisable() { 
    $db = $this->getDb();
    $db->query("UPDATE  `engine4_core_modules` SET  `enabled` =  '0' WHERE  `engine4_core_modules`.`name` ='eclassroom';");
    $db->commit();
    parent::onDisable();
  }
  function onEnable() {  
    $db = $this->getDb();
    $db->query("UPDATE  `engine4_core_modules` SET  `enabled` =  '1' WHERE  `engine4_core_modules`.`name` ='eclassroom';");
    $db->commit();
    parent::onEnable();
  }
}
