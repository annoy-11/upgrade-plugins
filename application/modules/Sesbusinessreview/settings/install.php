<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessreview_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {

    $db = $this->getDb();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sesbusiness')
            ->where('enabled = ?', 1);
    $sesbusiness_Check = $select->query()->fetchObject();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sesbusiness');
    $sesbusinessCheck = $select->query()->fetchAll();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_settings')
            ->where('name = ?', 'sesbusiness.pluginactivated')
            ->limit(1);
    $event_activate = $select->query()->fetchAll();

    if(!empty($sesbusiness_Check) && !empty($event_activate[0]['value'])) {
      $plugin_currentversion = '4.10.3';
      $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
      if($error != '1') {
        return $this->_error($error);
      }
    } elseif(!empty($sesbusiness_Check) && empty($event_activate[0]['value'])) {
        return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/business-directories-plugin/" target="_blank">Business Directories Plugin</a>" is installed on your website, but is not yet activated. So, please first activate it before installing the Business Directories - Reviews & Ratings Extension.</p></div></div></div>');
    } elseif(!empty($sesbusinessCheck) && empty($sesbusiness_Check)) {
        return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/business-directories-plugin/" target="_blank">Business Directories Plugin</a>" is installed on your website, but is not yet enabled. So, please first enable it from the "Manage" >> "Packages & Plugins" section to proceed further.</p></div></div></div>');
    } elseif(empty($sesbusinessCheck)) {
        return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required "<a href="https://www.socialenginesolutions.com/social-engine/business-directories-plugin/" target="_blank">Business Directories Plugin</a>" is not installed on your website. Please download the latest version of "<a href="https://www.socialenginesolutions.com/social-engine/business-directories-plugin/" target="_blank">Business Directories Plugin</a>" from <a href="https://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
    }
    parent::onPreinstall();
  }

  public function onInstall() {
    parent::onInstall();
  }
}
