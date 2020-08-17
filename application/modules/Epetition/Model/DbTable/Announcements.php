<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Announcements.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Model_DbTable_Announcements extends Core_Model_Item_DbTable_Abstract
{
  protected $_name = 'epetition_announcements';

  /**
   * Get Announcement Select
   */
  public function getAnnouncementSelect($params = array())
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getDbtable('announcements', 'epetition');
    // $rName = $table->info('name');
    //  //$tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
    // // $tmName = $tmTable->info('name');
    $select = $table->select()
      ->where('epetition_id =?', $params['epetition_id'])
      ->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $rName.'.created_date DESC' );

    return $select;
  }

  /**
   * Get Announcement Paginator
   */
  public function getAnnouncementPaginator($params = array())
  {
    $paginator = Zend_Paginator::factory($this->getAnnouncementSelect($params));
    if( !empty($params['page']) )
    {
      $paginator->setCurrentPageNumber($params['page']);
    }
    if( !empty($params['limit']) )
    {
      $paginator->setItemCountPerPage($params['limit']);
    }

    if( empty($params['limit']) )
    {
      $paginator->setItemCountPerPage(10);
    }

    return $paginator;
  }

  /**
   * Get Announcement by Viewer and petition id
   */
  public function isAnnouncement($params = array())
  {
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $this->select()
      ->from($this->info('name'), 'announcement_id')
      ->where('epetition_id = ?', $params['epetition_id'])
      ->where('created_by = ?', $viewerId);
    return $select = $select->query()->fetchColumn();
  }



}
