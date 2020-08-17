<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Recentlyviewitems.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Model_DbTable_Recentlyviewitems extends Engine_Db_Table {

  protected $_name = 'sesdiscussion_recentlyviewitems';
  protected $_rowClass = 'Sesdiscussion_Model_Recentlyviewitem';

  public function getitem($params = array()) {

    $discussionTableName = Engine_Api::_()->getItemTable('discussion')->info('name');

    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->info('name'), array('*'))
            ->where('resource_type = ?', 'sesdiscussion_discussion')
            ->order('creation_date DESC')
            ->limit($params['limit']);

    if ($params['criteria'] == 'by_me') {
      $select->where($this->info('name') . '.owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity());
    } else if ($params['criteria'] == 'by_myfriend') {
      /* friends array */
      $friendIds = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
      if (count($friendIds) == 0)
        return array();
      $select->where($this->info('name') . ".owner_id IN ('" . implode(',', $friendIds) . "')");
    }
    $select->joinLeft($discussionTableName, $discussionTableName . ".discussion_id =  " . $this->info('name') . '.resource_id', null);
    return $this->fetchAll($select);
  }
}
