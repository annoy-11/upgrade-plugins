<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Installer extends Engine_Package_Installer_Module {

  public function onInstall() {

    $db = $this->getDb();
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
        ->where('name = ?', 'sesbusiness.browse-businesses');
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
          'name' => 'sesbusiness.browse-businesses',
          'page_id' => $pageId,
          'parent_content_id' => ($tabId ? $tabId : $middleId),
          'order' => 100,
          'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","verifiedLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"250","height":"130","width":"215","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"150","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"9","grid_title_truncation":"45","grid_description_truncation":"100","height_grid":"220","width_grid":"304","dummy18":null,"limit_data_simplegrid":"9","simplegrid_title_truncation":"45","simplegrid_description_truncation":"50","height_simplegrid":"230","width_simplegrid":"304","dummy19":null,"limit_data_advgrid":"9","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"260","width_advgrid":"304","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"25","title":"Businesses","nomobile":"0","name":"sesbusiness.browse-businesses"}',
        ));
    }
  }
}
