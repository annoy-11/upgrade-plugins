<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Recentlyviewitems.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupvideo_Model_DbTable_Recentlyviewitems extends Engine_Db_Table {
  protected $_name = 'sesgroupvideo_recentlyviewitems';
  protected $_rowClass = 'Sesgroupvideo_Model_Recentlyviewitem';
  public function getitem($params = array()) {

      $itemTable = Engine_Api::_()->getItemTable('groupvideo');
      $itemTableName = $itemTable->info('name');
      $fieldName = 'video_id';
      $not = true;

		$subquery = $this->select()->from($this->info('name'),array('*','MAX(creation_date)'))->group($this->info('name').".resource_id")->order($this->info('name').".resource_id DESC")->where($this->info('name').'.resource_type =?', $params['type']);
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(array('engine4_sesgroupvideo_recentlyviewitems' => $subquery))
            ->where($this->info('name') .'.resource_type = ?', $params['type'])
            ->order('engine4_sesgroupvideo_recentlyviewitems.creation_date DESC')
            ->group($this->info('name') . '.resource_id')
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
    $select->joinLeft($itemTableName, $itemTableName . ".$fieldName =  " . $this->info('name') . '.resource_id', array('*'));
		if (isset($not)) {
				if (Engine_Api::_()->getApi('settings', 'core')->getSetting('video.enable.watchlater', 1)) {
				$viewer = Engine_Api::_()->user()->getViewer();
				$user_id = $viewer->getIdentity();
				$watchLaterTable = Engine_Api::_()->getDbTable('watchlaters', 'sesgroupvideo')->info('name');
				$select = $select->setIntegrityCheck(false);
				$select = $select->joinLeft($watchLaterTable, '(' . $watchLaterTable . '.video_id = ' . $this->info('name') . '.resource_id AND ' . $watchLaterTable . '.owner_id = ' . $user_id . ')', array('watchlater_id'));
			}
    }
    return Zend_Paginator::factory($select);
  }
}
