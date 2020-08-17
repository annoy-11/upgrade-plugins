<?php

class Seslocation_Installer extends Engine_Package_Installer_Module {
  public function onPreinstall() {
    $db = $this->getDb();
    
    parent::onPreinstall();
  }

  public function onInstall() {
    parent::onInstall();
  }
  
	public function onDisable(){
		 $db = $this->getDb();
		
		parent::onDisable();
 }
 public function onEnable(){
	  $db = $this->getDb();
	 
		parent::onEnable();
 }
}
