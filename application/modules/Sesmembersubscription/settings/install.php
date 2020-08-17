<?php

class Sesmembersubscription_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {
  
    $db = $this->getDb();
    
    parent::onPreinstall();
  }

  public function onInstall() {

    $db = $this->getDb();

    parent::onInstall();
  }
  
  
  public function onEnable() {

    $db = $this->getDb();

    $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '1' WHERE `engine4_core_menuitems`.`name` = 'sespaymentapi_edit_subscribe';");
    $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '1' WHERE `engine4_core_menuitems`.`name` = 'sesmembersubscription_manage_subscribes';");
    $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '1' WHERE `engine4_core_menuitems`.`name` = 'sesmembersubscription_edit_subscribe';");

    parent::onEnable();
  }

  public function onDisable() {
  
    $db = $this->getDb();

    $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '0' WHERE `engine4_core_menuitems`.`name` = 'sespaymentapi_edit_subscribe';");
    $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '0' WHERE `engine4_core_menuitems`.`name` = 'sesmembersubscription_manage_subscribes';");
    $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '0' WHERE `engine4_core_menuitems`.`name` = 'sesmembersubscription_edit_subscribe';");

    parent::onDisable();
  }
  
}