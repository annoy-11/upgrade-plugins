<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Installer extends Engine_Package_Installer_Module {

//   public function onPreinstall() {
//
//     $db = $this->getDb();
//     $plugin_currentversion = '4.10.3p8';
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
    //Member browse page
    $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesteam_index_browse-members')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$page_id) {
      $widgetOrder = 1;
      $db->insert('engine4_core_pages', array(
          'name' => 'sesteam_index_browse-members',
          'displayname' => 'Team Showcase - Browse Members Page',
          'title' => 'Team Showcase - Browse Members',
          'description' => 'This page show member lists.',
          'custom' => 0,
      ));
      $page_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'top',
          'page_id' => $page_id,
          'order' => 1,
      ));
      $top_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'main',
          'page_id' => $page_id,
          'order' => 2,
      ));
      $main_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'middle',
          'page_id' => $page_id,
          'parent_content_id' => $top_id,
      ));
      $top_middle_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'middle',
          'page_id' => $page_id,
          'parent_content_id' => $main_id,
          'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'left',
          'page_id' => $page_id,
          'parent_content_id' => $main_id,
          'order' => 1,
      ));
      $main_left_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'user.browse-menu',
          'page_id' => $page_id,
          'parent_content_id' => $top_middle_id,
          'order' => $widgetOrder++,
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesteam.browse-members',
          'page_id' => $page_id,
          'parent_content_id' => $main_middle_id,
          'order' => $widgetOrder++,
          'params' => '{"sesteam_template":"1","popularity":"creation_date","sesteam_contentshow":["displayname","profileType","status","email","message","addFriend","profileField","viewMore"],"labelBold":"1","age":"1","profileFieldCount":"3","viewMoreText":"View Details","height":"200","width":"200","sesteam_social_border":"1","center_block":"1","limitMembers":"10","title":"","nomobile":"0","name":"sesteam.browse-members"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'user.browse-search',
          'page_id' => $page_id,
          'parent_content_id' => $main_left_id,
          'order' => $widgetOrder++,
      ));
    }
    parent::onInstall();
  }

}
