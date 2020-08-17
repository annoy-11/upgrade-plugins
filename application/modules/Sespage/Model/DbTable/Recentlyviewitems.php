<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Recentlyviewitems.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_DbTable_Recentlyviewitems extends Engine_Db_Table {

  protected $_name = 'sespage_recentlyviewitems';
  protected $_rowClass = 'Sespage_Model_Recentlyviewitem';

  public function getitem($params = array()) {

    if (isset($params['type']) && $params['type'] == 'sespage_album') {
      $itemTable = Engine_Api::_()->getItemTable('sespage_album');
      $fieldName = 'album_id';
    } elseif (isset($params['type']) && $params['type'] == 'pagenote') {
      $itemTable = Engine_Api::_()->getItemTable('pagenote');
      $fieldName = 'pagenote_id';
    } elseif (isset($params['type']) && $params['type'] == 'pageoffer') {
      $itemTable = Engine_Api::_()->getItemTable('pageoffer');
      $fieldName = 'pageoffer_id';
    } else {
      $itemTable = Engine_Api::_()->getItemTable('sespage_page');
      $fieldName = 'page_id';
    }

    $itemTableName = $itemTable->info('name');
    $recentViewTableName = $this->info('name');

    $subquery = $this->select()->from($this->info('name'), array('*', 'MAX(creation_date) as maxcreadate'))->group($this->info('name') . ".resource_id")->where($this->info('name') . '.resource_type =?', $params['type']);
    if (isset($params['category_id']) && !empty($params['category_id'])) {
      $subquery->where($itemTable->info('name') . '. category_id =?', $params['category_id']);
    }
    if ($params['criteria'] == 'by_me') {
      $subquery->where($this->info('name') . '.owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity());
    } else if ($params['criteria'] == 'by_myfriend') {
      /* friends array */
      $friendIds = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
      if (count($friendIds) == 0)
        return array();
      $subquery->where($this->info('name') . ".owner_id IN ('" . implode(',', $friendIds) . "')");
    }
    $select = $this->select()
            ->from(array('engine4_sespage_recentlyviewitems' => $subquery))
            ->where($recentViewTableName . '.resource_type = ?', $params['type'])
            ->setIntegrityCheck(false)
            ->order('maxcreadate DESC')
            ->group($this->info('name') . '.resource_id');

    $select->joinLeft($itemTableName, $itemTableName . ".$fieldName =  " . $this->info('name') . '.resource_id', array('*'));
    $select->where($itemTableName . '.' . $fieldName . ' != ?', '');
    $select->where($itemTableName . '.' . $fieldName . ' != ?', '');
    $select->where($itemTableName . '.search != ?', '0');
    if (isset($params['limit'])) {
      $select->limit($params['limit']);
    }

    if(isset($params['showdefaultalbum']) && empty($params['showdefaultalbum'])) {
      $select->where($itemTableName.'.type IS NULL');
    }
    return $this->fetchAll($select);
  }
}
