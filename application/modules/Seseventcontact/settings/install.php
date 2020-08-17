<?php

class Seseventcontact_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {
  
    $db = $this->getDb();
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sesbasic');
    $sesbasic_enabled = $select->query()->fetchObject();
    if (empty($sesbasic_enabled)) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required SocialEngineSolutions Basic Required Plugin is not installed on your website. Please download the latest version of this FREE plugin from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
    } else {
      if (isset($sesbasic_enabled->enabled) && !empty($sesbasic_enabled->enabled)) {
        if ($sesbasic_enabled->version >= '4.8.9') {
          
        } else {
          return $this->_error('<div class="global_form"><div><div><p style="color:red;">The latest version of the SocialEngineSolutions Basic Required Plugin installed on your website is less than the minimum required version: ' . '4.8.9' . '. Please upgrade this Free plugin to its latest version after downloading the latest version of this plugin from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
        }
      } else {
        return $this->_error('<div class="global_form"><div><div><p style="color:red;">The SocialEngineSolutions Basic Required Plugin is installed but not enabled on your website. So, please first enable it from the "Manage" >> "Packages & Plugins" section.</p></div></div></div>');
      }
    }
    
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sesevent');
    $sesbasic_enabled = $select->query()->fetchObject();
    if (empty($sesbasic_enabled)) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required Advanced Events Plugin is not installed on your website. Please download the latest version of this plugin from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
    } else {
      if (isset($sesbasic_enabled->enabled) && !empty($sesbasic_enabled->enabled)) {
        if ($sesbasic_enabled->version >= '4.8.9') {
          
        } else {
          return $this->_error('<div class="global_form"><div><div><p style="color:red;">The latest version of the Advanced Events Plugin installed on your website is less than the minimum required version: ' . '4.8.9' . '. Please upgrade Advanced Events Plugin to its latest version after downloading the latest version of this plugin from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
        }
      } else {
        return $this->_error('<div class="global_form"><div><div><p style="color:red;">The Advanced Events Plugin is installed but not enabled on your website. So, please first enable it from the "Manage" >> "Packages & Plugins" section.</p></div></div></div>');
      }
    }

    parent::onPreinstall();
  }
    
	public function onInstall() {
  
    $db = $this->getDb();
    parent::onInstall();
  }
  
  public function onEnable() {
		$db = $this->getDb();
    parent::onEnable();
  }
  
  public function onDisable() {
		$db = $this->getDb();
    parent::onDisable();
  }
}