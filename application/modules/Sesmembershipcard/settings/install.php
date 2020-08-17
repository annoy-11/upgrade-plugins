<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershipcard_Installer extends Engine_Package_Installer_Module {

 

  public function onInstall() {
    $this->_addCardMemberProfile();
    parent::onInstall();
  }
  protected function _addCardMemberProfile()
  {
    $db = $this->getDb();
    $select = new Zend_Db_Select($db);

    // Get page id
    $pageId = $select
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'user_profile_index')
      ->limit(1)
      ->query()
      ->fetchColumn(0)
      ;

    // Check if it's already been placed
    $select = new Zend_Db_Select($db);
    $hasProfileCard = $select
      ->from('engine4_core_content', new Zend_Db_Expr('TRUE'))
      ->where('page_id = ?', $pageId)
      ->where('type = ?', 'widget')
      ->where('name = ?', 'sesmembershipcard.card')
      ->query()
      ->fetchColumn()
      ;

    // Add it
    if( !$hasProfileCard ) {

      // container_id (will always be there)
      $select = new Zend_Db_Select($db);
      $containerId = $select
        ->from('engine4_core_content', 'content_id')
        ->where('page_id = ?', $pageId)
        ->where('type = ?', 'container')
        ->limit(1)
        ->query()
        ->fetchColumn()
        ;

      // middle_id (will always be there)
      $select = new Zend_Db_Select($db);
      $middleId = $select
        ->from('engine4_core_content', 'content_id')
        ->where('parent_content_id = ?', $containerId)
        ->where('type = ?', 'container')
        ->where('name = ?', 'middle')
        ->limit(1)
        ->query()
        ->fetchColumn()
        ;

      // tab_id (tab container) may not always be there
      $select = new Zend_Db_Select($db);
      $select
        ->from('engine4_core_content', 'content_id')
        ->where('type = ?', 'widget')
        ->where('name = ?', 'core.container-tabs')
        ->where('page_id = ?', $pageId)
        ->limit(1);
      $tabId = $select->query()->fetchObject();
      if( $tabId && @$tabId->content_id ) {
          $tabId = $tabId->content_id;
      } else {
        $tabId = $middleId;
      }

      // insert
      if( $tabId ) {
        $db->insert('engine4_core_content', array(
          'page_id' => $pageId,
          'type'    => 'widget',
          'name'    => 'sesmembershipcard.card',
          'parent_content_id' => $tabId,
          'order'   => 8,
          'params'  => '{"title":"Membership Card"}',
        ));
      }
    }
  }
}
