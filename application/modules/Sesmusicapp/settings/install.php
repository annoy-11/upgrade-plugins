<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmusicapp_Installer extends Engine_Package_Installer_Module {

//     public function onPreinstall() {
//
//         $db = $this->getDb();
//
//         $select = new Zend_Db_Select($db);
//         $select->from('engine4_core_modules')
//                 ->where('name = ?', 'sesmusic')
//                 ->where('enabled = ?', 1);
//         $sesmusic_Check = $select->query()->fetchObject();
//
//         $select = new Zend_Db_Select($db);
//         $select->from('engine4_core_modules')
//                 ->where('name = ?', 'sesmusic');
//         $sesmusicCheck = $select->query()->fetchAll();
//
//         $select = new Zend_Db_Select($db);
//         $select->from('engine4_core_settings')
//                 ->where('name = ?', 'sesmusic.pluginactivated')
//                 ->limit(1);
//         $page_activate = $select->query()->fetchAll();
//
//         if(!empty($sesmusic_Check) && !empty($page_activate[0]['value'])) {
//             $plugin_currentversion = '4.10.3p12';
//             $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
//             if($error != '1') {
//                 return $this->_error($error);
//             }
//         } elseif(!empty($sesmusic_Check) && empty($page_activate[0]['value'])) {
//             return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/professional-music-plugin/" target="_blank">Professional Music Plugin</a>" is installed on your website, but is not yet activated. So, please first activate it before installing the Custom Music for Mobile Apps Extension.</p></div></div></div>');
//         } elseif(!empty($sesmusicCheck) && empty($sesmusic_Check)) {
//             return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/professional-music-plugin/" target="_blank">Professional Music Plugin</a>" is installed on your website, but is not yet enabled. So, please first enable it from the "Manage" >> "Packages & Plugins" section to proceed further.</p></div></div></div>');
//         } elseif(empty($sesmusicCheck)) {
//             return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required "<a href="https://www.socialenginesolutions.com/social-engine/professional-music-plugin/" target="_blank">Professional Music Plugin</a>" is not installed on your website. Please download the latest version of "<a href="https://www.socialenginesolutions.com/social-engine/professional-music-plugin/" target="_blank">Professional Music Plugin</a>" from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
//         }
//
//         parent::onPreinstall();
//     }

    public function onInstall() {
        parent::onInstall();
    }
}
