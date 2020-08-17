<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Decisionmakers.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Epetition_Model_DbTable_Decisionmakers extends Engine_Db_Table
{
  protected $_name = 'epetition_decisionmakers';

  /**
   * Decision maker Paginator
   */
  public function getDecisionmakerPaginator($params = array())
  {
    $paginator = Zend_Paginator::factory($this->getDecisionmakerSelect($params));
    if (!empty($params['page'])) {
      $paginator->setCurrentPageNumber($params['page']);
    }
    if (!empty($params['limit'])) {
      $paginator->setItemCountPerPage($params['limit']);
    }

    if (empty($params['limit'])) {
      $paginator->setItemCountPerPage(10);
    }

    return $paginator;
  }

  /**
   * List of Decision maker according petition;
   */
  public function getDecisionmakerSelect($params = array())
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getDbtable('decisionmakers', 'epetition');
    // $rName = $table->info('name');
    //  //$tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
    // // $tmName = $tmTable->info('name');
    $select = $table->select();
    $select = $select->where('epetition_id=?', $params['epetition_id']);
    $select = $select->order(!empty($params['orderby']) ? $params['orderby'] . ' DESC' : $rName . '.created_date DESC');
    return $select;
  }

  /**
   * List of Decision maker id according petition;
   */
  public function getAllUserId($epetition_id)
  {
    $epetition = $epetition = Engine_Api::_()->getItem('epetition', $epetition_id);
    $table = Engine_Api::_()->getDbTable('decisionmakers', 'epetition');
    $data = $table->select()->from($table->info('name'), 'user_id')
      ->where('epetition_id=?', $epetition_id)
      ->query()
      ->fetchAll();
    array_push($data, array('user_id' => $epetition['owner_id']));
    return $data;
  }

  /**
   * Here check Letter Approve or not;
   */
  public function checkLetterApprove($epetition_id, $status = null)
  {
    $table = Engine_Api::_()->getDbTable('decisionmakers', 'epetition');
    $data = $table->select()->from($table->info('name'), 'letter_approve')
      ->where('epetition_id=?', $epetition_id)
      ->query()
      ->fetchAll();
    $type = 0;
    foreach ($data as $datas) {
      if ($status != null && $type != 2) {
        $type = $datas['letter_approve'];
      } else {
        if ($datas['letter_approve'] == 0) {
          $type = 1;
        }
      }
    }
    return $type;
  }

}

