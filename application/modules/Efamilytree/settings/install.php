<?php

class Efamilytree_Installer extends Engine_Package_Installer_Module {
  public function onInstall() { 
    $db = $this->getDb();
    parent::onInstall();
  }
}
