<?php

class Sesvideosell_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {

    $db = $this->getDb();
    
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sesvideo')
            ->where('enabled = ?', 1);
    $sesvideo_check = $select->query()->fetchObject();
    
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sesvideo');
    $sesvideoCheck = $select->query()->fetchAll();
    
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_settings')
            ->where('name = ?', 'sesvideo.pluginactivated')
            ->limit(1);
    $video_activate = $select->query()->fetchAll();

    if(!empty($sesvideo_check) && !empty($video_activate[0]['value'])) {
      $plugin_currentversion = '4.8.13p9';
      $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
      if($error != '1') {
        return $this->_error($error);
      }
		} elseif(!empty($sesvideo_check) && empty($video_activate[0]['value'])) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/advanced-videos-channels-plugin/" target="_blank">Advanced Videos & Channels Plugin</a>" is installed on your website, but is not yet activated. So, please first activate it before installing the Advanced Videos & Channels - Sell Extension.</p></div></div></div>');
		} elseif(!empty($sesvideoCheck) && empty($sesvideo_check)) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/advanced-videos-channels-plugin/" target="_blank">Advanced Videos & Channels Plugin</a>" is installed on your website, but is not yet enabled. So, please first enable it from the "Manage" >> "Packages & Plugins" section to proceed further.</p></div></div></div>');
		} elseif(empty($sesvideoCheck)) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required "<a href="https://www.socialenginesolutions.com/social-engine/advanced-videos-channels-plugin/" target="_blank">Advanced Videos & Channels Plugin</a>" is not installed on your website. Please download the latest version of "<a href="https://www.socialenginesolutions.com/social-engine/advanced-videos-channels-plugin/" target="_blank">Advanced Videos & Channels Plugin</a>" from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');		
		}
    parent::onPreinstall();
  }

  public function onInstall() {

    $db = $this->getDb();
    parent::onInstall();
  }
}