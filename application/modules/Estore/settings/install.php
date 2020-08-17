<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Installer extends Engine_Package_Installer_Module {

  public function onInstall() {
    $db = $this->getDb();

    //Album View Page
    $page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesproduct_album_view')
                ->limit(1)
                ->query()
                ->fetchColumn();
    if (!$page_id) {
        $widgetOrder = 1;
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'sesproduct_album_view',
            'displayname' => 'SES - Stores Marketplace - Products - Album View Page',
            'title' => 'Product Album View',
            'description' => 'This page displays an Product album.',
            'provides' => 'subject=sesproduct_album',
            'custom' => 0,
        ));
        $page_id = $db->lastInsertId();
        // Insert main
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'main',
            'page_id' => $page_id,
            'order' => 2,
        ));
        $main_id = $db->lastInsertId();
        // Insert main-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $main_id,
            'order' => 6,
        ));
        $main_middle_id = $db->lastInsertId();

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesproduct.album-breadcrumb',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
            'params'=> '{"title":"","name":"sesproduct.album-breadcrumb"}'
        ));

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesproduct.album-view-page',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
            'params' => '{"view_type":"masonry","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","by","socialSharing","likeButton","favouriteButton"],"limit_data":"5","pagging":"button","title_truncation":"45","height":"160","width":"140","nomobile":"0","name":"sesproduct.album-view-page"}'
        ));
    }

    parent::onInstall();
  }
}
