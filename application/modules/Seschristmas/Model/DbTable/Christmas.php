<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Christmas.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seschristmas_Model_DbTable_Christmas extends Engine_Db_Table {

  protected $_rowClass = 'Seschristmas_Model_Christmas';

  public function getWish($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), array('christmas_id'))
            ->where('owner_id = ?', $params['owner_id']);
    return $select->query()->fetchColumn();
  }

  public function getFriendWishs($params = array()) {

    $select = $this->select()->from($this->info('name'))
            ->where('owner_id IN (?)', (array) $params['friend_ids'])
            ->order('creation_date DESC');
    return $select;
  }

  public function getAllWishs($params = array()) {

    return $this->select()->from($this->info('name'))->order('creation_date DESC');
  }

}
