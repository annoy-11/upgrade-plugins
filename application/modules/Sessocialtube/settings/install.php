<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {

    $db = $this->getDb();

    $plugin_currentversion = '4.8.10p1';
	  $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
	  if($error != '1') {
		  return $this->_error($error);
		}

    parent::onPreinstall();
  }

  public function onInstall() {

    $db = $this->getDb();
    
    $db->query("UPDATE `engine4_core_settings` SET `name` = 'sessocialtube.footertext.en' WHERE `engine4_core_settings`.`name` = 'sessocialtube.footertext';");
    
    $db->query("UPDATE `engine4_core_settings` SET `name` = 'sessocialtube.landinapagetext.en' WHERE `engine4_core_settings`.`name` = 'sessocialtube.landinapagetext';");
    
    
    $table_footerLinks = $db->query('SHOW TABLES LIKE \'engine4_sessocialtube_footerlinks\'')->fetch();
		if (!empty($table_footerLinks)) {
	    $columnfooterlink_exist = $db->query("SHOW COLUMNS FROM engine4_sessocialtube_footerlinks LIKE 'nonloginenabled'")->fetch();
			if (empty($columnfooterlink_exist)) {
			  $db->query("ALTER TABLE `engine4_sessocialtube_footerlinks` ADD `nonloginenabled` TINYINT(1) NOT NULL DEFAULT '1'");
			}

	    $columnnonlogintarget_exist = $db->query("SHOW COLUMNS FROM engine4_sessocialtube_footerlinks LIKE 'nonlogintarget'")->fetch();
			if (empty($columnnonlogintarget_exist)) {
			  $db->query("ALTER TABLE `engine4_sessocialtube_footerlinks` ADD `nonlogintarget` TINYINT(1) NOT NULL DEFAULT '1';");
			}
	    
	    $columnnonloginurl_exist = $db->query("SHOW COLUMNS FROM engine4_sessocialtube_footerlinks LIKE 'loginurl'")->fetch();
			if (empty($columnnonloginurl_exist)) {
			  $db->query("ALTER TABLE `engine4_sessocialtube_footerlinks` ADD `loginurl` VARCHAR(255) NOT NULL");
			}

	    $columnnonloginenabled_exist = $db->query("SHOW COLUMNS FROM engine4_sessocialtube_footerlinks LIKE 'loginenabled'")->fetch();
			if (empty($columnnonloginenabled_exist)) {
			  $db->query("ALTER TABLE `engine4_sessocialtube_footerlinks` ADD `loginenabled` TINYINT(1) NOT NULL DEFAULT '1'");
			}

	    $columnnonlogintarget_exist = $db->query("SHOW COLUMNS FROM engine4_sessocialtube_footerlinks LIKE 'logintarget'")->fetch();
			if (empty($columnnonlogintarget_exist)) {
			  $db->query("ALTER TABLE `engine4_sessocialtube_footerlinks` ADD `logintarget` TINYINT(1) NOT NULL DEFAULT '1'");
			}
		}
		
    
    $column_exist = $db->query("SHOW COLUMNS FROM engine4_core_menuitems LIKE 'file_id'")->fetch();
		if (empty($column_exist)) {
		  $db->query("ALTER TABLE `engine4_core_menuitems` ADD `file_id` INT( 11 ) NOT NULL;");
		}
		
		$column_exist = $db->query("SHOW COLUMNS FROM engine4_activity_notifications LIKE 'view_notification'")->fetch();
		if (empty($column_exist)) {
		  $db->query("ALTER TABLE `engine4_activity_notifications` ADD `view_notification` TINYINT( 1 ) NOT NULL AFTER `date`");
		}
		
		$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
		("core_mini_notification", "user", "Notifications", "", \'{"route":"default","module":"sessocialtube","controller":"notifications","action":"pulldown"}\', "core_mini", "", 999),
		("core_mini_friends", "user", "Friend Requests", "", \'{"route":"default","module":"sessocialtube","controller":"index","action":"friend-request"}\', "core_mini", "", 990);');

    parent::onInstall();
  }
  
  function onEnable() {

    $db = $this->getDb();

    //Header Work
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_content', 'name')
            ->where('page_id = ?', 1)
            ->where('name LIKE ?', '%core.menu-main%')
            ->limit(1);
    $info = $select->query()->fetch();
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_content', 'name')
            ->where('page_id = ?', 1)
            ->where('name LIKE ?', '%core.menu-mini%')
            ->limit(1);
    $info1 = $select->query()->fetch();
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_content', 'name')
            ->where('page_id = ?', 1)
            ->where('name LIKE ?', '%core.menu-logo%')
            ->limit(1);
    $info2 = $select->query()->fetch();
    $parent_content_id = $db->select()
		        ->from('engine4_core_content', 'content_id')
		        ->where('type = ?', 'container')
		        ->where('page_id = ?', '1')
		        ->where('name = ?', 'main')
		        ->limit(1)
		        ->query()
		        ->fetchColumn();
    if (!empty($info) && !empty($info1) && !empty($info2)) {
			$db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`name` = "core.menu-main";');
		  $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`name` = "core.menu-mini";');
		  $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`name` = "core.menu-logo";');
		  if($parent_content_id) {
			  $db->insert('engine4_core_content', array(
			      'type' => 'widget',
			      'name' => 'sessocialtube.header',
			      'page_id' => 1,
			      'parent_content_id' => $parent_content_id,
			      'order' => 20,
			  ));
		  }
    }

    //Footer Work
    $select = new Zend_Db_Select($db);
    $select
            ->from('engine4_core_content', 'name')
            ->where('page_id = ?', 2)
            ->where('name LIKE ?', '%menu-footer%')
            ->limit(1);
    $info = $select->query()->fetch();
    if (!empty($info)) {
      $db->update('engine4_core_content', array(
          'name' => 'sessocialtube.footer',
              ), array(
          'name = ?' => $info['name'],
      ));
    }
    $db->query("UPDATE `engine4_core_menuitems` SET  `enabled` =  '1' WHERE  `engine4_core_menuitems`.`name` ='core_mini_friends';");
    $db->query("UPDATE `engine4_core_menuitems` SET  `enabled` =  '1' WHERE  `engine4_core_menuitems`.`name` ='core_mini_notification';");
    
    //Theme Enabled and disabled
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_themes', 'name')
            ->where('active = ?', 1)
            ->limit(1);
    $themeActive = $select->query()->fetch(); 
    if($themeActive) {
			$db->query("UPDATE  `engine4_core_themes` SET  `active` =  '0' WHERE  `engine4_core_themes`.`name` ='".$themeActive['name']."' LIMIT 1");
	    $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '1' WHERE  `engine4_core_themes`.`name` ='sessocialtube' LIMIT 1");
    }

    parent::onEnable();
  }

  public function onDisable() {
  
    $db = $this->getDb();
    
    $db->query("UPDATE  `engine4_core_menuitems` SET  `enabled` =  '0' WHERE  `engine4_core_menuitems`.`name` ='core_mini_friends';");
    $db->query("UPDATE  `engine4_core_menuitems` SET  `enabled` =  '0' WHERE  `engine4_core_menuitems`.`name` ='core_mini_notification';");
    
    //Header Work
    $db->query("UPDATE  `engine4_core_content` SET  `name` =  'core.menu-mini' WHERE  `engine4_core_content`.`name` ='sessocialtube.header' LIMIT 1");
    $parent_content_id = $db->select()
		        ->from('engine4_core_content', 'content_id')
		        ->where('type = ?', 'container')
		        ->where('page_id = ?', '1')
		        ->where('name = ?', 'main')
		        ->limit(1)
		        ->query()
		        ->fetchColumn();
		if($parent_content_id) {
			$db->insert('engine4_core_content', array(
		      'type' => 'widget',
		      'name' => 'core.menu-logo',
		      'page_id' => 1,
		      'parent_content_id' => $parent_content_id,
		      'order' => 10,
		  ));
		  $db->insert('engine4_core_content', array(
		      'type' => 'widget',
		      'name' => 'core.menu-main',
		      'page_id' => 1,
		      'parent_content_id' => $parent_content_id,
		      'order' => 20,
		  ));
	  }
	  
	  //Footer Work
    $db->query("UPDATE  `engine4_core_content` SET  `name` =  'core.menu-footer' WHERE  `engine4_core_content`.`name` ='sessocialtube.footer' LIMIT 1");
    
    $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '0' WHERE  `engine4_core_themes`.`name` ='sessocialtube' LIMIT 1");
    $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '1' WHERE  `engine4_core_themes`.`name` ='default' LIMIT 1");

    parent::onDisable();
  }
}