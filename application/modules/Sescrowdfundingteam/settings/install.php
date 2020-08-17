<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfundingteam_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {

    $db = $this->getDb();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sescrowdfunding')
            ->where('enabled = ?', 1);
    $sescrowdfunding_Check = $select->query()->fetchObject();


    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sescrowdfunding');
    $sescrowdfundingCheck = $select->query()->fetchAll();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_settings')
            ->where('name = ?', 'sescrowdfunding.pluginactivated')
            ->limit(1);
    $page_activate = $select->query()->fetchAll();

    if(!empty($sescrowdfunding_Check) && !empty($page_activate[0]['value'])) {
      $plugin_currentversion = '4.10.3p8';
      $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
      if($error != '1') {
        return $this->_error($error);
      }
    } elseif(!empty($sescrowdfunding_Check) && empty($page_activate[0]['value'])) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/page-directories-plugin/" target="_blank">Page Directories Plugin</a>" is installed on your website, but is not yet activated. So, please first activate it before installing the Page Polls Extension.</p></div></div></div>');
    } elseif(!empty($sescrowdfundingCheck) && empty($sescrowdfunding_Check)) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/crowdfunding-directories-plugin/" target="_blank">Page Directories Plugin</a>" is installed on your website, but is not yet enabled. So, please first enable it from the "Manage" >> "Packages & Plugins" section to proceed further.</p></div></div></div>');
    } elseif(empty($sescrowdfundingCheck)) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required "<a href="https://www.socialenginesolutions.com/social-engine/crowdfunding-directories-plugin/" target="_blank">Page Directories Plugin</a>" is not installed on your website. Please download the latest version of "<a href="https://www.socialenginesolutions.com/social-engine/crowdfunding-directories-plugin/" target="_blank">Page Directories Plugin</a>" from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
    }

    parent::onPreinstall();
  }

  public function onInstall() {
    parent::onInstall();
  }
}
