<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_Installer extends Engine_Package_Installer_Module {

    public function onDisable() {

        $db = $this->getDb();

        //Header Work
        $db->query("UPDATE  `engine4_core_content` SET  `name` =  'core.menu-mini' WHERE  `engine4_core_content`.`name` ='sestwitterclone.header' LIMIT 1");
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
        $db->query("UPDATE  `engine4_core_content` SET  `name` =  'core.menu-footer' WHERE  `engine4_core_content`.`name` ='sestwitterclone.footer' LIMIT 1");

        $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '0' WHERE  `engine4_core_themes`.`name` ='sestwitterclone' LIMIT 1");
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
                    'name' => 'sestwitterclone.header',
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
                'name' => 'sestwitterclone.footer',
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
            $db->query("UPDATE  `engine4_core_themes` SET  `active` =  '1' WHERE  `engine4_core_themes`.`name` ='sestwitterclone' LIMIT 1");
        }

        //Member Home Page
        $page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'user_index_home')
                ->limit(1)
                ->query()
                ->fetchColumn();
        if($page_id) {
            $left_id = $db->select()
                ->from('engine4_core_content', 'content_id')
                ->where('page_id = ?', $page_id)
                ->where('type = ?', 'container')
                ->where('name = ?', 'left')
                ->limit(1)
                ->query()
                ->fetchColumn();

            $select = new Zend_Db_Select($db);
            $select->from('engine4_core_content', 'name')
                    ->where('page_id = ?', 4)
                    ->where('name = ?', 'sestwitterclone.home-photo')
                    ->limit(1);
            $home_photo = $select->query()->fetch();
            if(empty($home_photo)) {
                $db->insert('engine4_core_content', array(
                    'type' => 'widget',
                    'name' => 'sestwitterclone.home-photo',
                    'page_id' => $page_id,
                    'parent_content_id' => $left_id,
                    'order' => 1,
                ));
            }

            //Right Side Footer
            $right_id = $db->select()
                ->from('engine4_core_content', 'content_id')
                ->where('page_id = ?', $page_id)
                ->where('type = ?', 'container')
                ->where('name = ?', 'right')
                ->limit(1)
                ->query()
                ->fetchColumn();

            $select = new Zend_Db_Select($db);
            $select->from('engine4_core_content', 'name')
                    ->where('page_id = ?', 4)
                    ->where('name = ?', 'sestwitterclone.sidebar-footer')
                    ->limit(1);
            $sidebar_footer = $select->query()->fetch();
            if(empty($sidebar_footer)) {
                $db->insert('engine4_core_content', array(
                    'type' => 'widget',
                    'name' => 'sestwitterclone.sidebar-footer',
                    'page_id' => $page_id,
                    'parent_content_id' => $right_id,
                    'order' => 999,
                ));
            }
        }


        parent::onEnable();
    }

    public function onInstall() {
        parent::onInstall();
    }
}
