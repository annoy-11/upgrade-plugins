<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Pokes.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_Model_DbTable_Pokes extends Engine_Db_Table {

  protected $_rowClass = 'Sespoke_Model_Poke';

  public function getResults($params = array()) {
    
    $usersTable = Engine_Api::_()->getDbtable('users', 'user');
    $usersTableName = $usersTable->info('name');
    
    $name = $this->info('name');
    
    $select = $this->select()
                  ->from($name)
                  ->setIntegrityCheck(false)
                  ->join($usersTableName, $usersTableName . ".user_id = " . $name . ".poster_id  ", null);

    if (isset($params['viewer_id']))
      $select->where('receiver_id = ?', $params['viewer_id']);

    if (isset($params['user_id']))
      $select->where('poster_id = ?', $params['user_id']);

    if (isset($params['manageaction_id']))
      $select->where('manageaction_id = ?', $params['manageaction_id'])->limit($params['limit'])->order("RAND()");

    if (isset($params['limit']))
      $select->limit($params['limit']);
      
    $select->group($usersTableName.'.user_id');

    if (@$params['action'] == 'backwidget')
      return $select;
    else
      return $select->query()->fetchAll();
  }

  public function isPoke($params = array()) {
    $select = $this->select();
        if(!empty($params['poster_id']) && isset($params['poster_id']))
          $select->where('poster_id = ?', @$params['poster_id']);
        if(!empty($params['receiver_id']) && isset($params['receiver_id']))
          $select->where('receiver_id = ?', @$params['receiver_id']);
        if(!empty($params['manageaction_id']) && isset($params['manageaction_id']))
          $select->where('manageaction_id = ?', @$params['manageaction_id']);
    return $select->query()
                    ->fetchColumn();
  }

}
