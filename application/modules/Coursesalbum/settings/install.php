<?php

class Sesgroupalbum_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {
    parent::onPreinstall();
  }

  public function onInstall() {

    $db = $this->getDb();
    parent::onInstall();
  }
  
  public function onEnable() {
  
    parent::onEnable();
  }
  
  public function onDisable() {
  
    parent::onDisable();
  }

}
