<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Egroupjoinfees_Installer extends Engine_Package_Installer_Module {
  public function onPreinstall() {
    $db = $this->getDb();
    parent::onPreinstall();
  }
  public function onInstall() {
    parent::onInstall();
  }
}
