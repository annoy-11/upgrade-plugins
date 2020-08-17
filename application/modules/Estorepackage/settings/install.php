<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Estorepackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: install.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Estorepackage_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {

    $db = $this->getDb();


    parent::onPreinstall();
  }

  public function onInstall() {

    parent::onInstall();
  }
}
