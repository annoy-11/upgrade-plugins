<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Installer extends Engine_Package_Installer_Module {

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
//       if ($error != '1') {
//         return $this->_error($error);
//       }
//     }
//     parent::onPreinstall();
//   }

  public function onInstall() {

    $db = $this->getDb();

    //New Claims Group
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesgroup_index_claim')
      ->limit(1)
      ->query()
      ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
      $widgetOrder = 1;
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesgroup_index_claim',
        'displayname' => 'SES - Group Communities - New Claims Page',
        'title' => 'Group Claim',
        'description' => 'This page lists group entries.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();

      // Insert top
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
      ));
      $top_id = $db->lastInsertId();

      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => 2,
      ));
      $main_id = $db->lastInsertId();

      // Insert top-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
      ));
      $top_middle_id = $db->lastInsertId();

      // Insert main-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();

      // Insert main-right
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'right',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 1,
      ));
      $main_right_id = $db->lastInsertId();

      // Insert menu
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroup.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
      ));

      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroup.claim-group',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
      ));
    }


    //Browse Claim Requests Group
    $page_id = $db->select()
                  ->from('engine4_core_pages', 'page_id')
                  ->where('name = ?', 'sesgroup_index_claim-requests')
                  ->limit(1)
                  ->query()
                  ->fetchColumn();
    // insert if it doesn't exist yet
    if( !$page_id ) {
      $widgetOrder = 1;
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesgroup_index_claim-requests',
        'displayname' => 'SES - Group Communities - Browse Claim Requests Page',
        'title' => 'Group Claim Requests',
        'description' => 'This page lists group claims request entries.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();

      // Insert top
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
      ));
      $top_id = $db->lastInsertId();

      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => 2,
      ));
      $main_id = $db->lastInsertId();

      // Insert top-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
      ));
      $top_middle_id = $db->lastInsertId();

      // Insert main-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();

      // Insert main-right
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'right',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 1,
      ));
      $main_right_id = $db->lastInsertId();

      // Insert menu
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroup.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
      ));

      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroup.claim-requests',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
      ));
    }
    
    $this->_addHashtagSearchContent();
    parent::onInstall();
  }
  
  protected function _addHashtagSearchContent() {

    $db = $this->getDb();
    $select = new Zend_Db_Select($db);

    // hashtag search page
    $select
        ->from('engine4_core_pages')
        ->where('name = ?', 'core_hashtag_index')
        ->limit(1);
    $pageId = $select->query()->fetchObject()->page_id;

    // Check if it's already been placed
    $select = new Zend_Db_Select($db);
    $select
        ->from('engine4_core_content')
        ->where('page_id = ?', $pageId)
        ->where('type = ?', 'widget')
        ->where('name = ?', 'sesgroup.browse-groups');
    $info = $select->query()->fetch();

    if( empty($info) ) {

        // container_id (will always be there)
        $select = new Zend_Db_Select($db);
        $select
            ->from('engine4_core_content')
            ->where('page_id = ?', $pageId)
            ->where('type = ?', 'container')
            ->limit(1);
        $containerId = $select->query()->fetchObject()->content_id;

        // middle_id (will always be there)
        $select = new Zend_Db_Select($db);
        $select
            ->from('engine4_core_content')
            ->where('parent_content_id = ?', $containerId)
            ->where('type = ?', 'container')
            ->where('name = ?', 'middle')
            ->limit(1);
        $middleId = $select->query()->fetchObject()->content_id;

        // tab_id (tab container) may not always be there
        $select
            ->reset('where')
            ->where('type = ?', 'widget')
            ->where('name = ?', 'core.container-tabs')
            ->where('page_id = ?', $pageId)
            ->limit(1);
        $tabId = $select->query()->fetchObject();
        if( $tabId && @$tabId->content_id ) {
            $tabId = $tabId->content_id;
        } else {
            $tabId = null;
        }
        
        $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesgroup.browse-groups',
          'page_id' => $pageId,
          'parent_content_id' => ($tabId ? $tabId : $middleId),
          'order' => 100,
          'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","verifiedLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"250","height":"130","width":"215","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"150","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"9","grid_title_truncation":"45","grid_description_truncation":"100","height_grid":"220","width_grid":"304","dummy18":null,"limit_data_simplegrid":"9","simplegrid_title_truncation":"45","simplegrid_description_truncation":"50","height_simplegrid":"230","width_simplegrid":"304","dummy19":null,"limit_data_advgrid":"9","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"260","width_advgrid":"304","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"25","title":"Pages","nomobile":"0","name":"sesgroup.browse-groups"}',
        ));
    }
  }
}
