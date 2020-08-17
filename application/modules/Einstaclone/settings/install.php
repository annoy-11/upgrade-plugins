<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: install.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_Installer extends Engine_Package_Installer_Module {

  public function onInstall() {
    parent::onInstall();
  }
  
  public function onDisable() {

    $db = $this->getDb();

    //Header Work
    $db->query("UPDATE  `engine4_core_content` SET  `name` =  'core.menu-mini' WHERE  `engine4_core_content`.`name` ='einstaclone.header' LIMIT 1");
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
    $db->query("UPDATE  `engine4_core_content` SET  `name` =  'core.menu-footer' WHERE  `engine4_core_content`.`name` ='einstaclone.footer' LIMIT 1");
    $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '0' WHERE  `engine4_core_themes`.`name` ='einstaclone' LIMIT 1");
    $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '1' WHERE  `engine4_core_themes`.`name` ='insignia' LIMIT 1");
    parent::onDisable();
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
                'name' => 'einstaclone.header',
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
            'name' => 'einstaclone.footer',
                ), array(
            'name = ?' => $info['name'],
        ));
    }

    //Theme Enabled and disabled
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_themes', 'name')
            ->where('active = ?', 1)
            ->limit(1);
    $themeActive = $select->query()->fetch();
    if($themeActive) {
        $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '0' WHERE  `engine4_core_themes`.`name` ='".$themeActive['name']."' LIMIT 1");
        $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '1' WHERE  `engine4_core_themes`.`name` ='einstaclone' LIMIT 1");
    }
    parent::onEnable();
  }
}
