<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesstories
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: install.php 2018-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Sesstories_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {

    
    parent::onPreinstall();
  }

  public function onInstall() {
    
    $db = $this->getDb();
    
    parent::onInstall();
  }

}