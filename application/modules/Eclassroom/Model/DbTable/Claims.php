<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Claims.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Model_DbTable_Claims extends Engine_Db_Table {
  protected $_rowClass = "Eclassroom_Model_Claim";

  /**
   * Gets a paginator for eclassrooms
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getclassroomclaimsPaginator($params = array()) {

    $paginator = Zend_Paginator::factory($this->getclassroomclaimsSelect($params));
    if( !empty($params['page']) )
    $paginator->setCurrentPageNumber ($params['page']);
    if( !empty($params['limit']) )
    $paginator->setItemCountPerPage($params['limit']);
    if( empty($params['limit']) ) {
      $classroom = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.classroom', 10);
      $paginator->setItemCountPerPage($classroom);
    }
    return $paginator;
  }

  /**
   * Gets a select object for the user's eclassroom entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getclassroomclaimsSelect($params = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $classroomTableName = $this->info('name');
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
