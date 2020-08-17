<?php
class Esenangpay_Installer extends Engine_Package_Installer_Module
{

  public function onPreinstall()
  {
    $db = $this->getDb();
    parent::onPreinstall();
  }

  public function onEnable()
  {
    parent::onEnable();
    die;
  }

  public function onDisable()
  {
    parent::onDisable();
    die;
  }
}
