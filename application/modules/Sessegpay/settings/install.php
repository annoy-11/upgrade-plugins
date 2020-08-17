<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessegpay_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {
    $db = $this->getDb();

    parent::onPreinstall();
  }

  public function onInstall() {
    parent::onInstall();
  }
}
