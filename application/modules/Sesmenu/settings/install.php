<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmenu_Installer extends Engine_Package_Installer_Module {

    public function onInstall() {
        $db = $this->getDb();
        $db->query("UPDATE engine4_core_content SET `name` = 'sesmenu.main-menu' WHERE `name` = 'core.menu-main' AND `page_id` = '1';");
        parent::onInstall();
    }
    public function onDisable(){
        $db = $this->getDb();
        $db->query("UPDATE engine4_core_content SET `name` = 'core.menu-main' WHERE `name` = 'sesmenu.main-menu' AND `page_id` = '1';");
        parent::onDisable();
    }
    public function onEnable(){
        $db = $this->getDb();
        $db->query("UPDATE engine4_core_content SET `name` = 'sesmenu.main-menu' WHERE `name` = 'core.menu-main' AND `page_id` = '1';");
        parent::onEnable();
    }
}
