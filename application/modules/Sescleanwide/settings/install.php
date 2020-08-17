<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescleanwide
 * @package    Sescleanwide
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescleanwide_Installer extends Engine_Package_Installer_Module {



  public function onInstall() {
    $db = $this->getDb();
    $db->query('UPDATE `engine4_core_themes` SET `active` = "0";');
    $db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sescleanwide', 'Responsive Clean Wide Theme', '', 1)");
    parent::onInstall();
  }
}