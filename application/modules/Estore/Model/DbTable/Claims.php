<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Claims.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Model_DbTable_Claims extends Engine_Db_Table {
  protected $_rowClass = "Estore_Model_Claim"; 
  
  /**
   * Gets a paginator for estores
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getstoreclaimsPaginator($params = array()) {
  
    $paginator = Zend_Paginator::factory($this->getstoreclaimsSelect($params));
    if( !empty($params['page']) )
    $paginator->setCurrentPageNumber ($params['page']);
    if( !empty($params['limit']) )
    $paginator->setItemCountPerPage($params['limit']);
    if( empty($params['limit']) ) {
      $store = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.store', 10);
      $paginator->setItemCountPerPage($store);
    }
    return $paginator;
  }
  
  /**
   * Gets a select object for the user's estore entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getstoreclaimsSelect($params = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $storeTableName = $this->info('name');
    $select = $this->select()->where('user_id =?', $viewer->getIdentity())->where('status =?', 0);
    return $select;
  }
  
  public function claimCount() {
     $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
     return $this->select()
     ->from($this->info('name'), 'claim_id')
     ->where('user_id =?', $viewerId)
     ->where('status =?', 0)->query()->fetchColumn();
  }
  
}