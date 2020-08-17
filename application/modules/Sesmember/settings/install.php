<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Installer.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Installer extends Engine_Package_Installer_Module {

//   public function onPreinstall() {
//
//     $db = $this->getDb();
//     $plugin_currentversion = '4.10.3p22';
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

    $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sesmember_admin_main_managepages", "sesmember", "Manage Widgetize Page", "", \'{"route":"admin_default","module":"sesmember","controller":"settings", "action":"manage-widgetize-page"}\', "sesmember_admin_main", "", 999);');

    //Alphabetically Members Search Page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesmember_index_alphabetic-members-search')
      ->limit(1)
      ->query()
      ->fetchColumn();
    if( !$page_id ) {
      $widgetOrder = 1;
      $db->insert('engine4_core_pages', array(
        'name' => 'sesmember_index_alphabetic-members-search',
        'displayname' => 'SES - Advanced Members - Alphabetically Members Search Page',
        'title' => 'Alphabetically Members Search',
        'description' => ' This page show all members alphabetically of your website.',
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
        'type' => 'widget',
        'name' => 'sesmember.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
      ));

      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesmember.members-listing',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
      ));
    }

    //Admin Picks Members Page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesmember_index_editormembers')
      ->limit(1)
      ->query()
      ->fetchColumn();
    if( !$page_id ) {
      $widgetOrder = 1;
      $db->insert('engine4_core_pages', array(
        'name' => 'sesmember_index_editormembers',
        'displayname' => 'SES - Advanced Members - Admin Picks Members Page',
        'title' => 'Admin Picks Members',
        'description' => 'This page show all members choose by admin of your site.',
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
        'type' => 'widget',
        'name' => 'sesmember.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
      ));

      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesmember.browse-search',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPrated","featured","sponsored","verified"],"view":["0","1","3","week","month"],"default_search_type":"creation_date ASC","show_advanced_search":"1","network":"yes","alphabet":"yes","friend_show":"yes","search_title":"yes","browse_by":"yes","location":"yes","kilometer_miles":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","member_type":"yes","has_photo":"yes","is_online":"yes","is_vip":"yes","title":"","nomobile":"0","name":"sesmember.browse-search"}'
      ));

      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesmember.browse-members',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"enableTabs":["list","advlist","grid","advgrid","pinboard","map"],"openViewType":"advlist","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","vipLabel","message","friendButton","followButton","likeButton","likemainButton","socialSharing","like","location","rating","view","title","friendCount","mutualFriendCount","profileType","age","profileField","heading","labelBold","pinboardSlideshow"],"limit_data":"12","profileFieldCount":"5","pagging":"button","order":"mostSPviewed","show_item_count":"1","list_title_truncation":"45","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","main_height":"350","main_width":"585","height":"200","width":"250","photo_height":"250","photo_width":"284","info_height":"315","advgrid_height":"322","advgrid_width":"382","pinboard_width":"350","title":"","nomobile":"0","name":"sesmember.browse-members"}',
      ));
    }

    parent::onInstall();
  }

}
