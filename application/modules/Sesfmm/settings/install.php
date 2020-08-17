<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfmm_Installer extends Engine_Package_Installer_Module {

  public function onInstall() {

    $db = $this->getDb();
    parent::onInstall();
  }
}
