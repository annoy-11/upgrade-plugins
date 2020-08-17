<?php

class Sespaymentapi_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {
  
    $db = $this->getDb();
    
    parent::onPreinstall();
  }

  public function onInstall() {

    $db = $this->getDb();

    parent::onInstall();
  }
}