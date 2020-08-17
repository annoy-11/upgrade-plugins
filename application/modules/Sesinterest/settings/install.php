<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_Installer extends Engine_Package_Installer_Module {

  public function onInstall() {
    parent::onInstall();
  }

  public function onDisable(){
	  $db = $this->getDb();
	  $db->query("UPDATE engine4_user_signup SET enable = '0' WHERE class = 'Sesinterest_Plugin_Signup_Interest'");
	  parent::onDisable();
  }

  public function onEnable(){
	  $db = $this->getDb();
	  $db->query("UPDATE engine4_user_signup SET enable = '1' WHERE class = 'Sesinterest_Plugin_Signup_Interest'");
	  parent::onEnable();
  }
}
