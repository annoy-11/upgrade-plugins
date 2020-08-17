<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesadvancedheader_Installer extends Engine_Package_Installer_Module {

  public function onInstall() {
    $db = $this->getDb();
    parent::onInstall();
  }

  function onEnable() {

    $db = $this->getDb();
    $db->query('UPDATE `engine4_core_menuitems` SET `enabled` = "0" WHERE `engine4_core_menuitems`.`name` = "core_mini_update";');
    $db->query('UPDATE `engine4_core_menuitems` SET `enabled` = "0" WHERE `engine4_core_menuitems`.`name` = "core_mini_profile";');
    parent::onEnable();
  }

  public function onDisable() {

    $db = $this->getDb();
    $db->query('UPDATE `engine4_core_menuitems` SET `enabled` = "1" WHERE `engine4_core_menuitems`.`name` = "core_mini_update";');
    $db->query('UPDATE `engine4_core_menuitems` SET `enabled` = "1" WHERE `engine4_core_menuitems`.`name` = "core_mini_profile";');
    parent::onDisable();
  }
}
