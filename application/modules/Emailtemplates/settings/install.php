<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Emailtemplates_Installer extends Engine_Package_Installer_Module {

    public function onInstall() {
        $db = $this->getDb();
        parent::onInstall();
    }
}
