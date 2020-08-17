<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seselegant_Installer extends Engine_Package_Installer_Module {

//   public function onPreinstall() {
//
//     $db = $this->getDb();
//     $plugin_currentversion = '4.10.3p21';
//
//     //Check: Basic Required Plugin
//     $select = new Zend_Db_Select($db);
//     $select->from('engine4_core_modules')
//             ->where('name = ?', 'sesbasic');
//     $results = $select->query()->fetchObject();
//     if (empty($results)) {
//       return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required SocialEngineSolutions Basic Required Plugin is not installed on your website. Please download the latest version of this FREE plugin from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
//     } else {
//       $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
//       if($error != '1') {
//         return $this->_error($error);
//       }
// 		}
//     parent::onPreinstall();
//   }

  public function onInstall() {

    $db = $this->getDb();
    parent::onInstall();
  }

  function onEnable() {

    $db = $this->getDb();
    $select = new Zend_Db_Select($db);
    $select
            ->from('engine4_core_content', 'name')
            ->where('page_id = ?', 1)
            ->where('name LIKE ?', '%menu-main%')
            ->limit(1);
    $info = $select->query()->fetch();
    if (!empty($info)) {
      $db->update('engine4_core_content', array('name' => 'seselegant.menu-main'), array('name = ?' => $info['name']));
    }

    $select = new Zend_Db_Select($db);
    $select
            ->from('engine4_core_content', 'name')
            ->where('page_id = ?', 1)
            ->where('name LIKE ?', '%menu-mini%')
            ->limit(1);
    $info = $select->query()->fetch();
    if (!empty($info)) {
      $db->update('engine4_core_content', array('name' => 'seselegant.menu-mini', 'order' => 2), array(       'name = ?' => $info['name']));
    }

    $select = new Zend_Db_Select($db);
    $select
            ->from('engine4_core_content', 'name')
            ->where('page_id = ?', 2)
            ->where('name LIKE ?', '%menu-footer%')
            ->limit(1);
    $info = $select->query()->fetch();
    if (!empty($info)) {
      $db->update('engine4_core_content', array('name' => 'seselegant.menu-footer'), array('name = ?' => $info['name']));
    }

    //For upgradation only
    $db->query("INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ('seselegant.themeactive', '1');");

    //Theme Enabled and disabled
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_themes', 'name')
            ->where('active = ?', 1)
            ->limit(1);
    $themeActive = $select->query()->fetch();
    if($themeActive) {
        $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '0' WHERE  `engine4_core_themes`.`name` ='".$themeActive['name']."' LIMIT 1");
	    $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '1' WHERE  `engine4_core_themes`.`name` ='seselegant' LIMIT 1");
    }

    parent::onEnable();
  }

  public function onDisable() {
    $db = $this->getDb();
    $db->query("UPDATE  `engine4_core_content` SET  `name` =  'core.menu-mini' WHERE  `engine4_core_content`.`name` ='seselegant.menu-mini' LIMIT 1");
    $db->query("UPDATE  `engine4_core_content` SET  `name` =  'core.menu-main' WHERE  `engine4_core_content`.`name` ='seselegant.menu-main' LIMIT 1");
    $db->query("UPDATE  `engine4_core_content` SET  `name` =  'core.menu-footern' WHERE  `engine4_core_content`.`name` ='seselegant.menu-footer' LIMIT 1");

    $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '0' WHERE  `engine4_core_themes`.`name` ='seselegant' LIMIT 1");
    $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '1' WHERE  `engine4_core_themes`.`name` ='insignia' LIMIT 1");
    parent::onDisable();
  }
}
